<?php

namespace App\Validators;

class AutorValidator extends AbstractValidator
{
    protected array $rules = [
        'Nome' => 'required|string|max:40',
    ];
}
