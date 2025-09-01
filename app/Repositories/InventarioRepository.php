<?php

namespace App\Repositories;

use App\Models\Inventario;

class InventarioRepository
{
    public function allPaginated($perPage = 10)
    {
        return Inventario::orderBy('nome')->paginate($perPage);
    }

    public function create(array $data): Inventario
    {
        return Inventario::create($data);
    }

    public function update(Inventario $inventario, array $data): Inventario
    {
        $inventario->update($data);
        return $inventario;
    }

    public function delete(Inventario $inventario): bool
    {
        return $inventario->delete();
    }

    public function findById($id): ?Inventario
    {
        return Inventario::findOrFail($id);
    }

    public function all()
    {
        return Inventario::all();
    }


}
