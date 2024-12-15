<?php

namespace App\Services\Interfaces;

interface ILivroService
{
    public function getAll(array $params = []): iterable;
    public function getById(int $id): ?object;
    public function create(array $data): bool;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
