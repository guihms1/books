<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\IAssuntoRepository;
use App\Services\Interfaces\IAssuntoService;
use App\Validators\ValidatorFactory;

class AssuntoService implements IAssuntoService
{
    private $assuntoRepository;
    private $validatorFactory;

    public function __construct(
        IAssuntoRepository $assuntoRepository,
        ValidatorFactory $validatorFactory,
    ) {
        $this->assuntoRepository = $assuntoRepository;
        $this->validatorFactory = $validatorFactory;
    }

    public function getAll(array $params = []): iterable
    {
        return $this->assuntoRepository->getAll($params);
    }

    public function getById(int $id): ?object
    {
        $assunto = $this->assuntoRepository->getById($id);

        if (!$assunto) {
            throw new NotFoundException('Assunto não encontrado.', 404);
        }

        return $assunto;
    }

    public function create(array $data): bool
    {
        $validatedData = $this->validateData($data);

        return $this->assuntoRepository->create($validatedData);
    }

    public function update(int $id, array $data): bool
    {
        $validatedData = $this->validateData($data);
        $assunto = $this->assuntoRepository->getById($id);

        if (!$assunto) {
            throw new NotFoundException('Assunto não encontrado.', 404);
        }

        return $this->assuntoRepository->update($id, $validatedData);
    }

    public function delete(int $id): bool
    {
        $assunto = $this->assuntoRepository->getById($id);

        if (!$assunto) {
            throw new NotFoundException('Assunto não encontrado.', 404);
        }

        return $this->assuntoRepository->destroy($id);
    }

    public function validateData(array $data): array
    {
        $validator = $this->validatorFactory->create(ValidatorFactory::ASSUNTO);
        return $validator->validate($data);
    }
}
