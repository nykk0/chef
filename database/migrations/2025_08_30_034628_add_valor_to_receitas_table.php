<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('encomenda', function (Blueprint $table) {
            $table->decimal('valor', 10, 2)->after('quantidade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('encomenda', function (Blueprint $table) {
            $table->dropColumn('valor');
        });
    }
};
