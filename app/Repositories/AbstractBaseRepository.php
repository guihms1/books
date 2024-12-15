<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IBaseRepository;

abstract class AbstractBaseRepository implements IBaseRepository
{
    protected $model;

    public function getAll(array $params = []): iterable
    {
        $result = $this->model;

        foreach ($params as $key => $value) {
            $result = $result->where($key, $value);
        }

        return $result->get();
    }

    public function getById(int $id): ?object
    {
        return $this->model->find($id);
    }

    public function create(array $data): object|bool
    {
        $this->fill($data);
        return $this->model->save();
    }

    public function update(int $id, array $data): bool {
        return $this->model
            ->where($this->model->getKeyName(), $id)
            ->update($data);
    }

    public function destroy(int $id): bool
    {
        return $this->model->where($this->model->getKeyName(), $id)->delete();
    }

    protected function fill(array $data, array $fieldsToIgnore = []): void
    {
        foreach ($data as $key => $value) {
            if (!in_array($key, $fieldsToIgnore)) {
                $this->model->$key = $value;
            }
        }
    }
}
