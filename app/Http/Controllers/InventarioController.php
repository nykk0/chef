<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        $itens = Inventario::orderBy('nome')->paginate(10);
        return view('auth.inventario.index', compact('itens'));
    }


    public function create()
    {
        return view('auth.inventario.create');
    }

    private function converterParaSaida($quantidade, $unidade_compra, $unidade_saida)
    {
        $fatores = [
            'kg' => 1000,
            'g'  => 1,
            'mg' => 0.001,
            'l'  => 1000,
            'ml' => 1,
        ];

        return $quantidade * ($fatores[$unidade_compra] / $fatores[$unidade_saida]);
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
        ], [
            'nome.required' => 'O campo Nome é obrigatório.',
            'nome.string' => 'O campo Nome deve ser um texto.',
            'nome.max' => 'O campo Nome deve ter no máximo 255 caracteres.',

            'categoria.string' => 'O campo Categoria deve ser um texto.',
            'categoria.max' => 'O campo Categoria deve ter no máximo 255 caracteres.',

            'quantidade.required' => 'O campo Quantidade é obrigatório.',
            'quantidade.numeric' => 'O campo Quantidade deve ser numérico.',
            'quantidade.min' => 'O campo Quantidade não pode ser menor que 0.',

            'quantidade_minima.required' => 'O campo Quantidade Mínima é obrigatório.',
            'quantidade_minima.numeric' => 'O campo Quantidade Mínima deve ser numérico.',
            'quantidade_minima.min' => 'O campo Quantidade Mínima não pode ser menor que 0.',

            'unidade_compra.required' => 'O campo Unidade de Compra é obrigatório.',
            'unidade_compra.string' => 'O campo Unidade de Compra deve ser texto.',

            'unidade_saida.required' => 'O campo Unidade de Saída é obrigatório.',
            'unidade_saida.string' => 'O campo Unidade de Saída deve ser texto.',
        ]);

        $quantidade_convertida = $this->converterParaSaida(
            $request->quantidade,
            $request->unidade_compra,
            $request->unidade_saida
        );

        Inventario::create([
            'nome' => $request->nome,
            'categoria' => $request->categoria,
            'quantidade' => $quantidade_convertida,
            'quantidade_minima' => $request->quantidade_minima,
            'unidade_compra' => $request->unidade_compra,
            'unidade_saida' => $request->unidade_saida,
        ]);

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

        $inventario->update($request->all());
        return redirect()->route('inventario.index')->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy(Inventario $inventario)
    {
        $inventario->delete();
        return redirect()->route('inventario.index')->with('success', 'Item removido com sucesso!');
    }

    public function entrada(Request $request, $id)
    {
        $item = Inventario::findOrFail($id);
        $quantidade = $request->input('quantidade', 1);
        $item->quantidade += $quantidade;
        $item->save();

        return redirect()->back()->with('success', "Entrada de {$quantidade} unidades registrada!");
    }

    public function saida(Request $request, $id)
    {
        $item = Inventario::findOrFail($id);
        $quantidade = $request->input('quantidade', 1);

        if ($item->quantidade - $quantidade < 0) {
            return redirect()->back()->with('error', 'Não há estoque suficiente!');
        }

        $item->quantidade -= $quantidade;
        $item->save();

        return redirect()->back()->with('success', "Saída de {$quantidade} unidades registrada!");
    }


}
