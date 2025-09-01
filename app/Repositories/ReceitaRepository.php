<?php

namespace App\Repositories;

use App\Models\Receita;

class ReceitaRepository
{
    public function all()
    {
        return Receita::all();
    }

    public function findById($id): ?Receita
    {
        return Receita::findOrFail($id);
    }

    public function create(array $data): Receita
    {
        return Receita::create($data);
    }

    public function update(Receita $receita, array $data): Receita
    {
        $receita->update($data);
        return $receita;
    }

    public function delete(Receita $receita): bool
    {
        return $receita->delete();
    }

    public function findByIds(array $ids)
    {
        return Receita::whereIn('id', $ids)->get();
    }
}
