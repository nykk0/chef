<?php

namespace App\Services;

use App\Repositories\InventarioRepository;
use App\Models\Inventario;

class InventarioService
{
    protected $inventarioRepository;

    public function __construct(InventarioRepository $inventarioRepository)
    {
        $this->inventarioRepository = $inventarioRepository;
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

    public function listar($perPage = 10)
    {
        return $this->inventarioRepository->allPaginated($perPage);
    }

    public function criar(array $data): Inventario
    {
        $data['quantidade'] = $this->converterParaSaida(
            $data['quantidade'],
            $data['unidade_compra'],
            $data['unidade_saida']
        );

        return $this->inventarioRepository->create($data);
    }

    public function atualizar(Inventario $inventario, array $data): Inventario
    {
        return $this->inventarioRepository->update($inventario, $data);
    }

    public function deletar(Inventario $inventario): bool
    {
        return $this->inventarioRepository->delete($inventario);
    }

    public function registrarEntrada($id, $quantidade = 1): Inventario
    {
        $item = $this->inventarioRepository->findById($id);
        $item->quantidade += $quantidade;
        $item->save();

        return $item;
    }

    public function registrarSaida($id, $quantidade = 1)
    {
        $item = $this->inventarioRepository->findById($id);

        if ($item->quantidade - $quantidade < 0) {
            return false;
        }

        $item->quantidade -= $quantidade;
        $item->save();

        return $item;
    }
}
