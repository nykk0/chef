<?php

namespace App\Services;

use App\Repositories\ReceitaRepository;
use App\Repositories\InventarioRepository;
use App\Models\Receita;

class ReceitaService
{
    protected $receitaRepository;
    protected $inventarioRepository;

    public function __construct(ReceitaRepository $receitaRepository, InventarioRepository $inventarioRepository)
    {
        $this->receitaRepository = $receitaRepository;
        $this->inventarioRepository = $inventarioRepository;
    }

    public function listar()
    {
        return $this->receitaRepository->all();
    }

    public function listarIngredientes()
    {
        return $this->inventarioRepository->all();
    }

    public function criar(array $data): Receita
    {
        $ids = implode(',', $data['ingredientes']);
        $qtds = implode(',', $data['quantidades']);

        $payload = [
            'nome'             => $data['nome'],
            'ingredientes_ids' => $ids,
            'ingredientes_qtds'=> $qtds,
            'tempo_preparo'    => $data['tempo_preparo'],
            'modo_preparo'     => $data['modo_preparo'],
            'valor'            => $data['valor'],
        ];

        return $this->receitaRepository->create($payload);
    }

    public function atualizar($id, array $data): Receita
    {
        $receita = $this->receitaRepository->findById($id);

        $ids = implode(',', $data['ingredientes']);
        $qtds = implode(',', $data['quantidades']);

        $payload = [
            'nome'             => $data['nome'],
            'tempo_preparo'    => $data['tempo_preparo'],
            'modo_preparo'     => $data['modo_preparo'],
            'valor'            => $data['valor'],
            'ingredientes_ids' => $ids,
            'ingredientes_qtds'=> $qtds,
        ];

        return $this->receitaRepository->update($receita, $payload);
    }

    public function deletar($id): bool
    {
        $receita = $this->receitaRepository->findById($id);
        return $this->receitaRepository->delete($receita);
    }

    public function buscarPorId($id): Receita
    {
        return $this->receitaRepository->findById($id);
    }
}
