<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Livro_Autor', function (Blueprint $table) {
            $table->unsignedBigInteger('Livro_CodL');
            $table->unsignedBigInteger('Autor_CodAu');

            $table->primary(['Livro_CodL', 'Autor_CodAu']);

            $table->foreign('Livro_CodL')
                ->references('CodL')
                ->on('Livro')
                ->onDelete('cascade');
            $table->foreign('Autor_CodAu')
                ->references('CodAu')
                ->on('Autor')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Livro_Autor');
    }
};
