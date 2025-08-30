<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Receita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceitaController extends Controller
{
    public function index()
    {
        $receitas = Receita::all();
        return view('auth.receita.index', compact('receitas'));
    }

    public function create()
    {
        $ingredientes = Inventario::all();
        return view('auth.receita.create', compact('ingredientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'ingredientes' => 'required|array|min:1',
            'ingredientes.*' => 'exists:inventarios,id',
            'quantidades' => 'required|array|min:1',
            'quantidades.*' => 'numeric|min:1',
            'tempo_preparo' => 'required|string|max:255',
            'modo_preparo' => 'required|string',
            'valor' => 'required',
        ], [
            'nome.required' => 'O campo Nome é obrigatório.',
            'nome.string' => 'O campo Nome deve ser um texto.',
            'nome.max' => 'O campo Nome deve ter no máximo 255 caracteres.',

            'ingredientes.required' => 'Selecione ao menos um ingrediente.',
            'ingredientes.array' => 'Os ingredientes devem estar em formato de lista.',
            'ingredientes.*.exists' => 'Um dos ingredientes selecionados não existe.',

            'quantidades.required' => 'Informe as quantidades dos ingredientes.',
            'quantidades.array' => 'As quantidades devem estar em formato de lista.',
            'quantidades.*.numeric' => 'Cada quantidade deve ser numérica.',
            'quantidades.*.min' => 'Cada quantidade deve ser no mínimo 1.',

            'tempo_preparo.required' => 'O campo Tempo de Preparo é obrigatório.',
            'tempo_preparo.string' => 'O campo Tempo de Preparo deve ser um texto.',
            'tempo_preparo.max' => 'O campo Tempo de Preparo deve ter no máximo 255 caracteres.',

            'modo_preparo.required' => 'O campo Modo de Preparo é obrigatório.',
            'modo_preparo.string' => 'O campo Modo de Preparo deve ser um texto.',
            'valor.required' => 'O campo valor e obrigatorio.',
        ]);

        $ids = implode(',', $request->ingredientes);
        $qtds = implode(',', $request->quantidades);

        \App\Models\Receita::create([
            'nome' => $request->nome,
            'ingredientes_ids' => $ids,
            'ingredientes_qtds' => $qtds,
            'tempo_preparo' => $request->tempo_preparo,
            'modo_preparo' => $request->modo_preparo,
        ]);

        return redirect()->route('receita')->with('success', 'Receita cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $receita = Receita::findOrFail($id);
        $ingredientes = Inventario::all();

        return view('auth.receita.create', compact('receita', 'ingredientes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'tempo_preparo' => 'required|string',
            'modo_preparo' => 'required|string',
            'valor' => 'required|numeric|min:0',
            'ingredientes' => 'required|array',
            'quantidades' => 'required|array',
        ]);

        $ids = implode(',', $request->ingredientes);
        $qtds = implode(',', $request->quantidades);

        $receita = Receita::findOrFail($id);
        $receita->update([
            'nome' => $request->nome,
            'tempo_preparo' => $request->tempo_preparo,
            'modo_preparo' => $request->modo_preparo,
            'valor' => $request->valor,
            'ingredientes_ids' => $ids,
            'ingredientes_qtds' => $qtds,
        ]);

        return redirect()->route('receita')->with('success', 'Receita atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $receita = \App\Models\Receita::findOrFail($id);
        $receita->delete();

        return response()->json(['success' => true]);
    }



}
