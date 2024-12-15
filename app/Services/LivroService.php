<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\IAssuntoRepository;
use App\Repositories\Interfaces\IAutorRepository;
use App\Repositories\Interfaces\ILivroAssuntoRepository;
use App\Repositories\Interfaces\ILivroAutorRepository;
use App\Repositories\Interfaces\ILivroRepository;
use App\Services\Interfaces\ILivroService;
use App\Validators\ValidatorFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LivroService implements ILivroService
{
    private $livroRepository;
    private $assuntoRepository;
    private $autorRepository;
    private $livroAssuntoRepository;
    private $livroAutorRepository;
    private $validatorFactory;

    public function __construct(
        ILivroRepository $livroRepository,
        IAssuntoRepository $assuntoRepository,
        IAutorRepository $autorRepository,
        ILivroAssuntoRepository $livroAssuntoRepository,
        ILivroAutorRepository $livroAutorRepository,
        ValidatorFactory $validatorFactory,
    )
    {
        $this->livroRepository = $livroRepository;
        $this->assuntoRepository = $assuntoRepository;
        $this->autorRepository = $autorRepository;
        $this->livroAssuntoRepository = $livroAssuntoRepository;
        $this->livroAutorRepository = $livroAutorRepository;
        $this->validatorFactory = $validatorFactory;
    }

    public function getAll(array $params = []): iterable
    {
        return $this->livroRepository->getAll($params);
    }

    public function getById(int $id): ?object
    {
        $livro = $this->livroRepository->getById($id);

        if (!$livro) {
            throw new NotFoundException('Livro não encontrado.', 404);
        }

        return $livro;
    }

    public function create(array $data): bool
    {
        $validatedData = $this->validateData($data);

        try {
            DB::beginTransaction();

            $livro = $this->createLivro($validatedData);

            if ($livro) {
                $this->attachAssuntosToLivro($livro->CodL, $validatedData['CodAs']);
                $this->attachAutoresToLivro($livro->CodL, $validatedData['CodAu']);
            }

            DB::commit();
            return (bool) $livro;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Erro ao cadastrar livro.');
            return false;
        }
    }

    private function createLivro(array $data): ?object
    {
        $livroAttributes = $this->extractLivroAttributes($data);
        return $this->livroRepository->create($livroAttributes);
    }

    private function extractLivroAttributes(array $data): array
    {
        $attributesToExtract = ['Titulo', 'Editora', 'Edicao', 'AnoPublicacao', 'Valor'];
        return array_intersect_key($data, array_flip($attributesToExtract));
    }

    private function attachAssuntosToLivro(int $livroCodL, array $assuntos): void
    {
        foreach ($assuntos as $codAs) {
            $this->livroAssuntoRepository->create([
                'Livro_CodL' => $livroCodL,
                'Assunto_CodAs' => $codAs,
            ]);
        }
    }

    private function attachAutoresToLivro(int $livroCodL, array $autores): void
    {
        foreach ($autores as $codAu) {
            $this->livroAutorRepository->create([
                'Livro_CodL' => $livroCodL,
                'Autor_CodAu' => $codAu,
            ]);
        }
    }

    public function update(int $id, array $data): bool
    {
        $validatedData = $this->validateData($data);
        try {
            DB::beginTransaction();

            $livro = $this->livroRepository->getById($id);

            if (!$livro) {
                throw new NotFoundException('Livro não encontrado.', 404);
            }

            $livroAttributes = $this->extractLivroAttributes($validatedData);
            $livroUpdated = $this->updateLivroAttributes($id, $livroAttributes);
            $hasChanges = $this->hasChanges($livro, $livroAttributes);

            // If none of the fields has been changed for "Livro" object, we still must proceed
            // and process "autores" and "assuntos".
            if ($livroUpdated || !$hasChanges) {
                $this->updateAssuntosLivro($livro->CodL, $validatedData['CodAs']);
                $this->updateAutoresLivro($livro->CodL, $validatedData['CodAu']);
            }

            DB::commit();
            return $livroUpdated || !$hasChanges;
        } catch (NotFoundException $exception) {
            DB::rollBack();
            throw $exception;
        }  catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Erro ao atualizar livro: ' . $exception->getMessage());
            return false;
        }
    }

    private function hasChanges(object $livro, array $livroAttributes): bool
    {
        foreach ($livroAttributes as $key => $value) {
            if ($livro->{$key} != $value) {
                return true;
            }
        }

        return false;  // No changes
    }

    public function updateLivroAttributes($id, $livroAttributes): bool
    {
        return $this->livroRepository->update($id, $livroAttributes);
    }

    public function updateAssuntosLivro(int $codL, array $assuntos): void
    {
        if ($this->livroAssuntoRepository->deleteByCodL($codL)) {
            $this->attachAssuntosToLivro($codL, $assuntos);
        }
    }

    public function updateAutoresLivro(int $codL, array $autores): void
    {
        if ($this->livroAutorRepository->deleteByCodL($codL)) {
            $this->attachAutoresToLivro($codL, $autores);
        }
    }

    public function delete(int $id): bool
    {
        $livro = $this->livroRepository->getById($id);

        if (!$livro) {
            throw new NotFoundException('Livro não encontrado.', 404);
        }

        return $this->livroRepository->destroy($id);
    }

    public function validateData(array $data): array
    {
        $validator = $this->validatorFactory->create(ValidatorFactory::LIVRO);
        return $validator->validate($data);
    }
}
