<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW autores_report AS
            SELECT
                a.CodAu AS Cod_Autor,
                a.Nome AS Nome_Autor,
                GROUP_CONCAT(
                    DISTINCT CONCAT(
                        l.Titulo, ' (', IFNULL(assuntos.Assuntos, ''), ')'
                    ) ORDER BY l.Titulo SEPARATOR ' / '
                ) AS Livros
            FROM
                Autor a
            LEFT JOIN
                Livro_Autor la ON a.CodAu = la.Autor_CodAu
            LEFT JOIN
                Livro l ON la.Livro_CodL = l.CodL
            LEFT JOIN (
                SELECT
                    ls.Livro_CodL,
                    GROUP_CONCAT(DISTINCT s.Descricao ORDER BY s.Descricao SEPARATOR ', ') AS Assuntos
                FROM
                    Livro_Assunto ls
                LEFT JOIN
                    Assunto s ON ls.Assunto_CodAs = s.CodAs
                GROUP BY
                    ls.Livro_CodL
            ) AS assuntos ON l.CodL = assuntos.Livro_CodL
            GROUP BY
                a.CodAu, a.Nome;
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS autores_report");
    }
};
