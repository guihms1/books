<?php

namespace App\Validators;

class AssuntoValidator extends AbstractValidator
{
    protected array $attributes = [
        'Descricao' => 'Descrição'
    ];
    protected array $rules = [
        'Descricao' => 'required|string|max:20'
    ];
}
