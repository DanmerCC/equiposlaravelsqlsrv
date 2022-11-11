<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    function list(Request $request)
    {
        $queryBase = Equipo::with('asesor');

        if ($request->has('search') && $request->get('search') != '') {
            $queryBase->search($request->get('search'));
        }
        return $this->sendResponse($queryBase->paginate(), "Correctamente cargado");
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
            'observacion',
            'procesador',
            'memoria',
            'disco_duro',
        ];

        $inputs = $request->only($allowed);

        $equipo->update($inputs);

        return $this->sendResponse($inputs, "Correctamente actualziado");
    }
}
