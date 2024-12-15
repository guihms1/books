<?php

namespace App\Repositories;

use App\Models\LivroAssunto;
use App\Repositories\Interfaces\ILivroAssuntoRepository;

class LivroAssuntoRepository extends AbstractBaseRepository implements ILivroAssuntoRepository
{
    protected $model;

    public function __construct(
        LivroAssunto $livroAssunto
    ) {
        $this->model = $livroAssunto;
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
