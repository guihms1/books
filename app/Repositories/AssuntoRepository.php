<?php

namespace App\Repositories;

use App\Models\Assunto;
use App\Repositories\Interfaces\IAssuntoRepository;

class AssuntoRepository extends AbstractBaseRepository implements IAssuntoRepository
{
    protected $model;

    public function __construct(
        Assunto $assunto
    )
    {
        $this->model = $assunto;
    }

    public function getById(int $id): ?object
    {
        return $this->model
            ->with('livros')
            ->find($id);
    }
}
