<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Livro_Assunto', function (Blueprint $table) {
            $table->unsignedBigInteger('Livro_CodL');
            $table->unsignedBigInteger('Assunto_CodAs');

            $table->primary(['Livro_CodL', 'Assunto_CodAs']);

            $table->foreign('Livro_CodL')
                ->references('CodL')
                ->on('Livro')
                ->onDelete('cascade');
            $table->foreign('Assunto_CodAs')
                ->references('CodAs')
                ->on('Assunto')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Livro_Assunto');
    }
};
