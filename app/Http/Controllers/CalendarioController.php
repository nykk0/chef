<?php

namespace App\Http\Controllers;

use App\Models\Encomenda;
use App\Models\Receita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarioController extends Controller
{
    public function index(){
        return view("auth.calendario.index");
    }


    public function getEntregas(Request $request)
    {
        $dia = $request->dia;
        $mes = $request->mes;
        $ano = $request->ano;

        $encomendas = Encomenda::whereDate('data', "$ano-$mes-$dia")->get();

        $result = $encomendas->map(function($encomenda) {


            // separa os IDs de receitas
            $receitaIds = explode(',', $encomenda->receita);
            $quantidades = explode(',', $encomenda->quantidade);

            // busca todas as receitas correspondentes
            $receitas = Receita::whereIn('id', $receitaIds)->get()->keyBy('id');

            // monta array com nome da receita e quantidade
            $itens = [];
            foreach ($receitaIds as $index => $id) {
                if (isset($receitas[$id])) {
                    $itens[] = [
                        'nome' => $receitas[$id]->nome,
                        'quantidade' => $quantidades[$index] ?? 0,
                        'valor' => $receitas[$id]->valor,
                    ];
                }
            }


            return [
                'nome_cliente' => $encomenda->nome_cliente,
                'valor' => $encomenda->valor,
                'itens' => $itens,
            ];
        });
        return response()->json($result);
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
