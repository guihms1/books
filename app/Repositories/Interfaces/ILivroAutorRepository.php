<?php

namespace App\Repositories\Interfaces;

interface ILivroAutorRepository
{
    public function deleteByCodL(int $codL): bool;
}
