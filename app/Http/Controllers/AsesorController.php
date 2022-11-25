<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAsesorRequest;
use App\Models\Asesor;

use Illuminate\Http\Request;

class AsesorController extends Controller
{
    function list(Request $request)
    {
        $baseQuery = Asesor::with('equipo')->orderBy('id', 'desc');
        if ($request->has('search')) {

            $states = ["LABORANDO","VACACIONES"];
            if(in_array($request->get('search'),$states)) {
                //dd("hola");
                $baseQuery = $baseQuery->whereEstado($request->get('search'));
            }else{

                $baseQuery = $baseQuery->search($request->get('search'));
            }

            $paginated = $baseQuery->paginate();

            return $this->sendResponse($paginated, "Correctamente cargado");
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

    function create(CreateAsesorRequest $request){
        $asesor = Asesor::create($request->only([
            'dni',
            'nombres',
            'apellido_paterno',
            'apellido_materno',
            'estado'
        ]));
        return $this->sendResponse($asesor,"Correctamente creado");
    }
}
