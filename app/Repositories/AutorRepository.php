<?php

namespace App\Repositories;

use App\Models\Autor;
use App\Repositories\Interfaces\IAutorRepository;

class AutorRepository extends AbstractBaseRepository implements IAutorRepository
{
    protected $model;

    public function __construct(
        Autor $autor
    ) {
        $this->model = $autor;
    }

    public function getById(int $id): ?object
    {
        return $this->model
            ->with('livros')
            ->find($id);
    }
}
