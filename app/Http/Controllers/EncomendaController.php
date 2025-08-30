<?php

namespace App\Http\Controllers;

use App\Models\Encomenda;
use App\Models\Receita;
use Illuminate\Http\Request;

class EncomendaController extends Controller
{

    public function index(Request $request)
    {
        $query = Encomenda::query();

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por datas
        if ($request->filled('data_inicial')) {
            $query->whereDate('data', '>=', $request->data_inicial);
        }
        if ($request->filled('data_final')) {
            $query->whereDate('data', '<=', $request->data_final);
        }

        // Paginação
        $encomendas = $query->orderBy('data', 'desc')->paginate(10);

        // Mantém os filtros nos links da paginação
        $encomendas->appends($request->all());

        // Transformar receita e quantidade em array de itens com nome e valor
        $encomendas->getCollection()->transform(function ($encomenda) {
            // IDs das receitas
            $receitaIds = $encomenda->receita ? array_map('trim', explode(',', $encomenda->receita)) : [];
            $quantidades = $encomenda->quantidade ? array_map('trim', explode(',', $encomenda->quantidade)) : [];

            // Busca as receitas correspondentes
            $receitas = Receita::whereIn('id', $receitaIds)->get()->keyBy('id');

            // Monta array de itens
            $itens = [];
            foreach ($receitaIds as $index => $id) {
                if (isset($receitas[$id])) {
                    $itens[] = [
                        'nome' => $receitas[$id]->nome,
                        'quantidade' => $quantidades[$index] ?? 1,
                        'valor' => $receitas[$id]->valor,
                    ];
                }
            }

            // Adiciona os itens na encomenda
            $encomenda->itens = $itens;

            return $encomenda;
        });

        return view('auth.encomenda.index', compact('encomendas'));
    }



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
            'data.required' => 'Favor informar uma data!',
            'nome_cliente.required' => 'Favor informar o nome do cliente!',
            'itens.required' => 'Deverá haver pelo menos uma receita!',
            'itens.*.receita.required' => 'O campo receita é obrigatório!',
            'itens.*.receita.exists' => 'A receita selecionada não existe!',
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

        if (!$encomenda) {
            return redirect()->route('encomenda.create')->withErrors('error', 'Erro ao criar a encomenda!');
        }

        return redirect()->route('encomenda.index')->with('success', "Encomenda para {$request->nome_cliente} criada com sucesso!");
    }

    public function destroy(Encomenda $encomenda)
    {
        $encomenda->delete();

        return response()->json(['success' => true]);
    }

    public function processar(Request $request, $id)
    {
        $encomenda = Encomenda::findOrFail($id);
        $status = $request->input('status'); // <- pega do body JSON

        if (!in_array($status, ['pendente', 'confirmado', 'finalizado'])) {
            return response()->json(['success' => false], 400);
        }

        $encomenda->status = $status;
        $encomenda->save();

        return response()->json([
            'success' => true,
            'status' => $status
        ]);
    }
}
