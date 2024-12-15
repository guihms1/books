<?php

namespace App\Repositories\Interfaces;

interface IBaseRepository
{
    public function getAll(array $params = []): iterable;
    public function getById(int $id): ?object;
    public function create(array $data): object|bool;
    public function update(int $id, array $data): bool;
    public function destroy(int $id): bool;
}
