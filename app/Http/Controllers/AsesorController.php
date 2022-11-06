<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use Illuminate\Http\Request;

class AsesorController extends Controller
{
    function list(Request $request)
    {
        if ($request->has('search')) {

            return $this->sendResponse(Asesor::search($request->get('search'))->paginate(), "Correctamente cargado");
        }
        return $this->sendResponse(Asesor::paginate(), "Correctamente cargado");
    }

    function update($id, Request $request)
    {
        $asesor = Asesor::find($id);

        if ($asesor == null) {
            return $this->sendError(null, "No existe");
        }

        $allowed = [
            'asesor_id',
            'grupo',
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
