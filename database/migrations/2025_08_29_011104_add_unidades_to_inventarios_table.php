<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('categoria')->nullable();
            $table->integer('quantidade')->default(0);
            $table->integer('quantidade_minima')->default(1);
            $table->timestamps();
        });

        Schema::table('inventarios', function (Blueprint $table) {
            $table->string('unidade_compra')->default('kg');
            $table->string('unidade_saida')->default('g');
        });
    }

    public function down(): void
    {
        DB::statement('DROP table IF EXISTS inventarios');
        Schema::table('inventarios', function (Blueprint $table) {
            $table->dropColumn(['unidade_compra', 'unidade_saida']);
        });
    }
};
