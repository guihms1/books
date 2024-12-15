<?php

namespace App\Validators;

class ValidatorFactory
{
    public const ASSUNTO = 'assunto';
    public const AUTOR = 'autor';
    public const LIVRO = 'livro';

    public function create(string $validator)
    {
        switch ($validator) {
            case self::ASSUNTO:
                return new AssuntoValidator();
                break;
            case self::AUTOR:
                return new AutorValidator();
                break;
            case self::LIVRO:
                return new LivroValidator();
        }
    }
}
