<?php

namespace App\Http\Controllers;

use App\Services\EncomendaService;
use Illuminate\Http\Request;
use App\Models\Encomenda;

class EncomendaController extends Controller
{
    protected $encomendaService;

    public function __construct(EncomendaService $encomendaService)
    {
        $this->encomendaService = $encomendaService;
    }

    public function index(Request $request)
    {
        $encomendas = $this->encomendaService->listarComFiltros($request);
        return view('auth.encomenda.index', compact('encomendas'));
    }

    public function create()
    {
        $receitas = $this->encomendaService->listarReceitas();
        return view('auth.encomenda.create', compact('receitas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'data' => 'required|date',
            'nome_cliente' => 'required|string',
            'itens' => 'required|array|min:1',
            'itens.*.receita' => 'required|exists:receitas,id',
            'itens.*.quantidade' => 'required|integer|min:1',
        ]);

        $this->encomendaService->criar($request->all());

        return redirect()->route('encomenda.index')->with('success', "Encomenda para {$request->nome_cliente} criada com sucesso!");
    }

    public function destroy(Encomenda $encomenda)
    {
        $this->encomendaService->deletar($encomenda);
        return response()->json(['success' => true]);
    }

    public function processar(Request $request, $id)
    {
        try {
            $encomenda = $this->encomendaService->atualizarStatus($id, $request->input('status'));
            return response()->json([
                'success' => true,
                'status' => $encomenda->status,
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }
}
