<?php

namespace App\Http\Controllers;

use App\Models\Encomenda;
use App\Models\Receita;
use Illuminate\Http\Request;

class EncomendaController extends Controller
{


    public function create()
    {
        $receitas = Receita::all();
        return view("auth.encomenda.create", compact('receitas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'data' => 'required|date',
            'nome_cliente' => 'required|string',
            'itens' => 'required|array|min:1',
            'itens.*.receita' => 'required|exists:receitas,id',
            'itens.*.quantidade' => 'required|integer|min:1',
        ], [
            'data.required'=> 'Favor informar uma data!',
            'nome_cliente.required'=> 'Favor informar o nome do cliente!',
            'itens.required'=> 'Deverá haver pelo menos uma receita!',
            'itens.*.receita.required'=> 'O campo receita é obrigatório!',
            'itens.*.receita.exists'=> 'A receita selecionada não existe!',
            'itens.*.quantidade.required' => 'A Receita devera ter pelo menos 1 unidade!',
            'itens.*.quantidade.min' => 'A quantidade deve ser no mínimo 1!',
        ]);

        $receitasIds = collect($request->itens)->pluck('receita')->implode(',');
        $quantidades = collect($request->itens)->pluck('quantidade')->implode(',');

        $encomenda = \App\Models\Encomenda::create([
            'nome_cliente' => $request->nome_cliente,
            'telefone' => $request->telefone,
            'data' => $request->data,
            'valor' => $request->valor,
            'receita' => $receitasIds, // ids separados
            'quantidade' => $quantidades, // qtd separada
        ]);

        if(!$encomenda){
            return redirect()->route('encomenda.create')->withErrors('error', 'Erro ao criar a encomenda!');
        }

        return redirect()->route('encomenda.create')->with('success', "Encomenda para {$request->nome_cliente} criada com sucesso!");
    }
}
