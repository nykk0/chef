<?php

namespace App\Http\Controllers;

use App\Services\ReceitaService;
use Illuminate\Http\Request;

class ReceitaController extends Controller
{
    protected $receitaService;

    public function __construct(ReceitaService $receitaService)
    {
        $this->receitaService = $receitaService;
    }

    public function index()
    {
        $receitas = $this->receitaService->listar();
        return view('auth.receita.index', compact('receitas'));
    }

    public function create()
    {
        $ingredientes = $this->receitaService->listarIngredientes();
        return view('auth.receita.create', compact('ingredientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'         => 'required|string|max:255',
            'ingredientes' => 'required|array|min:1',
            'ingredientes.*'=> 'exists:inventarios,id',
            'quantidades'  => 'required|array|min:1',
            'quantidades.*'=> 'numeric|min:1',
            'tempo_preparo'=> 'required|string|max:255',
            'modo_preparo' => 'required|string',
            'valor'        => 'required|numeric|min:0',
        ]);

        $this->receitaService->criar($request->all());

        return redirect()->route('receita')->with('success', 'Receita cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $receita = $this->receitaService->buscarPorId($id);
        $ingredientes = $this->receitaService->listarIngredientes();

        return view('auth.receita.create', compact('receita', 'ingredientes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome'         => 'required|string|max:255',
            'tempo_preparo'=> 'required|string',
            'modo_preparo' => 'required|string',
            'valor'        => 'required|numeric|min:0',
            'ingredientes' => 'required|array',
            'quantidades'  => 'required|array',
        ]);

        $this->receitaService->atualizar($id, $request->all());

        return redirect()->route('receita')->with('success', 'Receita atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $this->receitaService->deletar($id);
        return response()->json(['success' => true]);
    }
}
