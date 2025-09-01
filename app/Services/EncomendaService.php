<?php

namespace App\Services;

use App\Repositories\EncomendaRepository;
use App\Repositories\ReceitaRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Encomenda;

class EncomendaService
{
    protected $encomendaRepository;
    protected $receitaRepository;

    public function __construct(EncomendaRepository $encomendaRepository, ReceitaRepository $receitaRepository)
    {
        $this->encomendaRepository = $encomendaRepository;
        $this->receitaRepository = $receitaRepository;
    }

    public function listarComFiltros(Request $request): LengthAwarePaginator
    {
        $query = $this->encomendaRepository->query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('data_inicial')) {
            $query->whereDate('data', '>=', $request->data_inicial);
        }

        if ($request->filled('data_final')) {
            $query->whereDate('data', '<=', $request->data_final);
        }

        $encomendas = $this->encomendaRepository->paginate($query, 10);
        $encomendas->appends($request->all());

        $encomendas->getCollection()->transform(function ($encomenda) {
            $receitaIds = $encomenda->receita ? array_map('trim', explode(',', $encomenda->receita)) : [];
            $quantidades = $encomenda->quantidade ? array_map('trim', explode(',', $encomenda->quantidade)) : [];

            $receitas = $this->receitaRepository->findByIds($receitaIds)->keyBy('id');

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

            $encomenda->itens = $itens;
            return $encomenda;
        });

        return $encomendas;
    }

    public function criar(array $data): Encomenda
    {
        $receitasIds = collect($data['itens'])->pluck('receita')->implode(',');
        $quantidades = collect($data['itens'])->pluck('quantidade')->implode(',');

        $payload = [
            'nome_cliente' => $data['nome_cliente'],
            'telefone'     => $data['telefone'] ?? null,
            'data'         => $data['data'],
            'valor'        => $data['valor'] ?? 0,
            'receita'      => $receitasIds,
            'quantidade'   => $quantidades,
        ];

        return $this->encomendaRepository->create($payload);
    }

    public function deletar(Encomenda $encomenda): bool
    {
        return $this->encomendaRepository->delete($encomenda);
    }

    public function atualizarStatus($id, string $status): Encomenda
    {
        if (!in_array($status, ['pendente', 'confirmado', 'finalizado'])) {
            throw new \InvalidArgumentException("Status inválido");
        }

        $encomenda = $this->encomendaRepository->findById($id);
        $encomenda->status = $status;
        $encomenda->save();

        return $encomenda;
    }

    public function listarReceitas()
    {
        return $this->receitaRepository->all();
    }
}
