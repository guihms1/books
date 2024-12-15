<?php

namespace App\Repositories;

use App\Models\Livro;
use App\Repositories\Interfaces\ILivroRepository;

class LivroRepository extends AbstractBaseRepository implements ILivroRepository
{
    protected $model;

    public function __construct(
        Livro $livro
    )
    {
        $this->model = $livro;
    }

    public function getById(int $id): ?object
    {
        return $this->model
            ->with('autores', 'assuntos')
            ->find($id);
    }

    public function create(array $data): object|bool
    {
        $this->fill($data);

        if (!$this->model->save()) {
            throw new \Exception("Erro ao salvar Livro");
        }

        return $this->model;
    }
}
