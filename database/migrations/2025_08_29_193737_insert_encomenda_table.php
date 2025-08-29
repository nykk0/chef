<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Inserindo 5 registros com datas diferentes
        DB::table('encomenda')->insert([
            [
                'nome_cliente' => 'Cliente 1',
                'telefone'     => '(11) 99999-0001',
                'receita'      => 'Receita A',
                'quantidade'   => 2,
                'data'         => '2025-08-01',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nome_cliente' => 'Cliente 2',
                'telefone'     => '(11) 99999-0002',
                'receita'      => 'Receita B',
                'quantidade'   => 5,
                'data'         => '2025-08-05',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nome_cliente' => 'Cliente 3',
                'telefone'     => '(11) 99999-0003',
                'receita'      => 'Receita C',
                'quantidade'   => 1,
                'data'         => '2025-08-10',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nome_cliente' => 'Cliente 4',
                'telefone'     => '(11) 99999-0004',
                'receita'      => 'Receita D',
                'quantidade'   => 3,
                'data'         => '2025-08-15',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nome_cliente' => 'Cliente 5',
                'telefone'     => '(11) 99999-0005',
                'receita'      => 'Receita E',
                'quantidade'   => 4,
                'data'         => '2025-08-20',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('encomenda');
    }
};
