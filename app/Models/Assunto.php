<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assunto extends Model
{
    protected $table = 'Assunto';
    protected $primaryKey = 'CodAs';
    protected $fillable = [
        'CodAs',
        'Descricao'
    ];
    public $timestamps = false;

    public function livros()
    {
        return $this->belongsToMany(
            Livro::class,
            'Livro_Assunto',
            'Assunto_CodAs',
            'Livro_CodL'
        );
    }
}
