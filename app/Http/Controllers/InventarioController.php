<?php

namespace App\Http\Controllers;

use App\Services\InventarioService;
use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    protected $inventarioService;

    public function __construct(InventarioService $inventarioService)
    {
        $this->inventarioService = $inventarioService;
    }

    public function index()
    {
        $itens = $this->inventarioService->listar();
        return view('auth.inventario.index', compact('itens'));
    }

    public function create()
    {
        return view('auth.inventario.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'categoria' => 'nullable|string|max:255',
            'quantidade' => 'required|numeric|min:0',
            'quantidade_minima' => 'required|numeric|min:0',
            'unidade_compra' => 'required|string',
            'unidade_saida' => 'required|string',
        ]);

        $this->inventarioService->criar($request->all());

        return redirect()->route('inventario.index')->with('success', 'Item adicionado com sucesso!');
    }

    public function edit(Inventario $inventario)
    {
        return view('auth.inventario.edit', compact('inventario'));
    }

    public function update(Request $request, Inventario $inventario)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'categoria' => 'nullable|string|max:255',
            'quantidade' => 'required|integer|min:0',
            'quantidade_minima' => 'required|integer|min:0',
        ]);

        $this->inventarioService->atualizar($inventario, $request->all());

        return redirect()->route('inventario.index')->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy(Inventario $inventario)
    {
        $this->inventarioService->deletar($inventario);
        return redirect()->route('inventario.index')->with('success', 'Item removido com sucesso!');
    }

    public function entrada(Request $request, $id)
    {
        $quantidade = $request->input('quantidade', 1);
        $this->inventarioService->registrarEntrada($id, $quantidade);

        return redirect()->back()->with('success', "Entrada de {$quantidade} unidades registrada!");
    }

    public function saida(Request $request, $id)
    {
        $quantidade = $request->input('quantidade', 1);
        $item = $this->inventarioService->registrarSaida($id, $quantidade);

        if (!$item) {
            return redirect()->back()->with('error', 'Não há estoque suficiente!');
        }

        return redirect()->back()->with('success', "Saída de {$quantidade} unidades registrada!");
    }
}
