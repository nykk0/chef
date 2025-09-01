<?php

namespace App\Repositories;

use App\Models\Encomenda;
use App\Models\Receita;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EncomendaRepository
{
    public function query()
    {
        return Encomenda::query();
    }

    public function findById($id): Encomenda
    {
        return Encomenda::findOrFail($id);
    }

    public function create(array $data): Encomenda
    {
        return Encomenda::create($data);
    }

    public function update(Encomenda $encomenda, array $data): Encomenda
    {
        $encomenda->update($data);
        return $encomenda;
    }

    public function delete(Encomenda $encomenda): bool
    {
        return $encomenda->delete();
    }

    public function paginate($query, $perPage = 10): LengthAwarePaginator
    {
        return $query->orderBy('data', 'desc')->paginate($perPage);
    }

    public function getEntregasByDate($ano, $mes, $dia)
    {
        $encomendas = Encomenda::whereDate('data', "$ano-$mes-$dia")->get();

        return $encomendas->map(function ($encomenda) {
            $receitaIds = explode(',', $encomenda->receita);
            $quantidades = explode(',', $encomenda->quantidade);

            $receitas = Receita::whereIn('id', $receitaIds)->get()->keyBy('id');

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
                'status' => $encomenda->status ?? 'pendente',
            ];
        });
    }

    public function getDiasComEntrega($ano, $mes)
    {
        $dias = Encomenda::whereMonth('data', $mes)
            ->whereYear('data', $ano)
            ->pluck('data');

        return $dias->map(fn($data) => (int) date('j', strtotime($data)))
                    ->unique()
                    ->values();
    }


}
