<?php

namespace App\Repositories\Interfaces;

interface ILivroAssuntoRepository
{
    public function deleteByCodL(int $codL): bool;
}
