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

            $states = ["LABORANDO","VACACIONES"];
            if(in_array($request->get('search'),$states)) {
                $baseQuery->whereEstado($request->get('search'));
            }

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
            'dni',
            'nombres',
            'apellido_paterno',
            'apellido_materno',
            'equipo_id',
            'estado'
        ];

        $inputs = $request->only($allowed);

        $asesor->update($inputs);

        return $this->sendResponse($inputs, "Correctamente actualziado");
    }

    function delete($id){
        $asesor = Asesor::find($id);

        $asesor->delete();

        return $this->sendResponse($asesor, "Correctamente eliminado");
    }
}
