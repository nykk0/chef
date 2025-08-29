<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EncomendaController extends Controller
{
    public function create(){
        return view("auth.encomenda.create");
    }
}
