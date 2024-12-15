<?php

namespace App\Repositories;

use App\Models\LivroAutor;
use App\Repositories\Interfaces\ILivroAutorRepository;

class LivroAutorRepository extends AbstractBaseRepository implements ILivroAutorRepository
{
    protected $model;

    public function __construct(
        LivroAutor $livroAutor,
    ) {
        $this->model = $livroAutor;
    }

    public function create(array $data): object|bool
    {
        $this->model = $this->model->newInstance();
        $this->fill($data);

        return $this->model->save();
    }

    public function deleteByCodL(int $codL): bool
    {
        return $this->model->where('Livro_CodL', $codL)->delete();
    }
}
