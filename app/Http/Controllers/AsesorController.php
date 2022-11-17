<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use Illuminate\Http\Request;

class AsesorController extends Controller
{
    function list(Request $request)
    {
        $baseQuery = Asesor::with('equipo');
        if ($request->has('search')) {

            return $this->sendResponse($baseQuery->search($request->get('search'))->paginate(), "Correctamente cargado");
        }
        return $this->sendResponse($baseQuery->paginate(), "Correctamente cargado");
    }

    function update($id, Request $request)
    {
        $asesor = Asesor::find($id);

        if ($asesor == null) {
            return $this->sendError(null, "No existe");
        }

        $allowed = [
            'equipo_id',
            'marca',
            'modelo',
            'color',
            'serie',
            'fecha_compra',
            'observacion'
        ];

        $inputs = $request->only($allowed);

        $asesor->update($inputs);

        return $this->sendResponse($inputs, "Correctamente actualziado");
    }
}
