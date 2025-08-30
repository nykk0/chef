<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'ingredientes_ids',
        'ingredientes_qtds',
        'tempo_preparo',
        'valor',
        'modo_preparo'
    ];
}
