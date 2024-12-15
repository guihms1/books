<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\IAutorRepository;
use App\Services\Interfaces\IAutorService;
use App\Validators\ValidatorFactory;

class AutorService implements IAutorService
{
    private $autorRepository;
    private $validatorFactory;

    public function __construct(
        IAutorRepository $autorRepository,
        ValidatorFactory $validatorFactory,
    ) {
        $this->autorRepository = $autorRepository;
        $this->validatorFactory = $validatorFactory;
    }

    public function getAll(array $params = []): iterable
    {
        return $this->autorRepository->getAll($params);
    }

    public function getById(int $id): ?object
    {
        $autor = $this->autorRepository->getById($id);

        if (!$autor) {
            throw new NotFoundException('Autor não encontrado.', 404);
        }

        return $autor;
    }

    public function create(array $data): bool
    {
        $validatedData = $this->validateData($data);

        return $this->autorRepository->create($validatedData);
    }

    public function update(int $id, array $data): bool
    {
        $validatedData = $this->validateData($data);
        $autor = $this->autorRepository->getById($id);

        if (!$autor) {
            throw new NotFoundException('Autor não encontrado.', 404);
        }

        return $this->autorRepository->update($id, $validatedData);
    }

    public function delete(int $id): bool
    {
        $autor = $this->autorRepository->getById($id);

        if (!$autor) {
            throw new NotFoundException('Autor não encontrado.', 404);
        }

        return $this->autorRepository->destroy($id);
    }

    public function validateData(array $data): array
    {
        $validator = $this->validatorFactory->create(ValidatorFactory::AUTOR);
        return $validator->validate($data);
    }
}
