<?php

namespace App\Validators\Interfaces;

interface IValidator
{
    public function validate($data): array;
}
