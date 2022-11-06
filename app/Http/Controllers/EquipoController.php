<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    function list(Request $request)
    {
        return $this->sendResponse(Equipo::with('asesor')->paginate(), "Correctamente cargado");
    }

    function update($id, Request $request)
    {
        $equipo = Equipo::find($id);

        if ($equipo == null) {
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

        $equipo->update($inputs);

        return $this->sendResponse($inputs, "Correctamente actualziado");
    }
}
