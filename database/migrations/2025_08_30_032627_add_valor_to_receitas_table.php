<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('receitas', function (Blueprint $table) {
            $table->decimal('valor', 10, 2)->after('modo_preparo')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('receitas', function (Blueprint $table) {
            $table->dropColumn('valor');
        });
    }
};
