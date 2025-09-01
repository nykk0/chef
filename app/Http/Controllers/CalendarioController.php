<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EncomendaRepository;

class CalendarioController extends Controller
{
    protected $encomendaRepo;

    public function __construct(EncomendaRepository $encomendaRepo)
    {
        $this->encomendaRepo = $encomendaRepo;
    }

    public function index()
    {
        return view("auth.calendario.index");
    }

    public function getEntregas(Request $request)
    {
        $result = $this->encomendaRepo->getEntregasByDate(
            $request->ano,
            $request->mes,
            $request->dia
        );

        return response()->json($result);
    }

    public function getDiasComEntrega(Request $request)
    {
        $dias = $this->encomendaRepo->getDiasComEntrega(
            $request->ano,
            $request->mes
        );

        return response()->json($dias);
    }
}
