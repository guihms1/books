<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Assunto', function (Blueprint $table) {
            $table->id('CodAs');
            $table->string('Descricao', 20);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Assunto');
    }
};
