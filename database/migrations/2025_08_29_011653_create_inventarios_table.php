<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::table('inventarios')->insert([
            [
                'nome' => 'Farinha de Trigo',
                'categoria' => 'Ingrediente',
                'quantidade' => 5000, // 5 kg -> g
                'quantidade_minima' => 1000,
                'unidade_compra' => 'kg',
                'unidade_saida' => 'g',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Açúcar',
                'categoria' => 'Ingrediente',
                'quantidade' => 3000, // 3 kg -> g
                'quantidade_minima' => 500,
                'unidade_compra' => 'kg',
                'unidade_saida' => 'g',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Manteiga',
                'categoria' => 'Ingrediente',
                'quantidade' => 1000, // 1 kg -> g
                'quantidade_minima' => 200,
                'unidade_compra' => 'kg',
                'unidade_saida' => 'g',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Ovos',
                'categoria' => 'Ingrediente',
                'quantidade' => 50,
                'quantidade_minima' => 10,
                'unidade_compra' => 'unidade',
                'unidade_saida' => 'unidade',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Leite',
                'categoria' => 'Ingrediente',
                'quantidade' => 2000, // 2 L -> mL
                'quantidade_minima' => 500,
                'unidade_compra' => 'l',
                'unidade_saida' => 'ml',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Chocolate em Pó',
                'categoria' => 'Ingrediente',
                'quantidade' => 500, // 500 g
                'quantidade_minima' => 100,
                'unidade_compra' => 'kg',
                'unidade_saida' => 'g',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Limão',
                'categoria' => 'Ingrediente',
                'quantidade' => 500, // g
                'quantidade_minima' => 100,
                'unidade_compra' => 'kg',
                'unidade_saida' => 'g',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
    }
};
