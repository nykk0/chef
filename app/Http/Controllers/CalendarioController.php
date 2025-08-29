<?php

namespace App\Http\Controllers;

use App\Models\Encomenda;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    public function index(){
        return view("auth.calendario.index");
    }
    
    public function getEntregas(Request $request) {
       $dia = $request->dia;
       $mes = $request->mes;
       $ano = $request->ano;

       $entregas = Encomenda::whereDay('data', $dia)
                       ->whereMonth('data', $mes)
                       ->whereYear('data', $ano)
                       ->get();

       return response()->json($entregas);
   }

    public function getDiasComEntrega(Request $request)
{
    $mes = $request->mes;
    $ano = $request->ano;

    $dias = Encomenda::whereMonth('data', $mes)
                ->whereYear('data', $ano)
                ->pluck('data');

    $diasDoMes = $dias->map(function ($data) {
        return (int) date('j', strtotime($data));
    })->unique()->values();

    return response()->json($diasDoMes);
}
}
