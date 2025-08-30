<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encomenda extends Model
{
    use HasFactory;
    protected $table = "encomenda";
    protected $fillable = [
        'nome_cliente',
        'telefone',
        'receita',
        'data',
        'status',
        'quantidade',
        'valor'
    ];
}
