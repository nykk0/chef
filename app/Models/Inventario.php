<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'categoria',
        'quantidade',
        'quantidade_minima',
        'unidade_compra',
        'unidade_saida',
    ];
}
