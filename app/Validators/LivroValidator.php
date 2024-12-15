<?php

namespace App\Validators;

class LivroValidator extends AbstractValidator
{
    protected array $attributes = [
        'Titulo' => 'Título',
        'Edicao' => 'Edição',
        'Editora' => 'Editora',
        'AnoPublicacao' => 'Ano de Publicação',
        'Valor' => 'Valor',
        'CodAu' => 'Autores',
        'CodAs' => 'Assuntos'
    ];
    protected array $rules = [
        'Titulo' => 'required|string|max:40',
        'Edicao' => 'required|numeric',
        'Editora' => 'required|string|max:40',
        'AnoPublicacao' => 'required|string|size:4',
        'Valor' => 'required|regex:/^\d{1,6}(\.\d{1,2})?$/|decimal:2',
        'CodAu' => 'required',
        'CodAs' => 'required',
        'CodAu.*' => 'exists:Autor,CodAu',
        'CodAs.*' => 'exists:Assunto,CodAs',
    ];
}
