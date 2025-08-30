<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receitas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('ingredientes_ids');
            $table->text('ingredientes_qtds');
            $table->string('tempo_preparo');
            $table->text('modo_preparo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receitas');
    }
};
