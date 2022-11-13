<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListEquiposRequest;
use App\Models\Equipo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    function list(ListEquiposRequest $request)
    {
        $queryBase = Equipo::with('asesor');

        $queryBase->orderBy('id', 'DESC');

        if ($request->has('noasigned')) {
            $queryBase->whereNull('asesor_id');
        }

        if ($request->has('vacaciones_filter')) {
            $vacaciones_filter = $request->get('vacaciones_filter') == "true";
            if ($vacaciones_filter) {
                $queryBase->whereHas('asesor', function (Builder $query) use ($vacaciones_filter) {
                    $query->whereEstado('VACACIONES');
                });
            } else {
                $queryBase->whereHas('asesor', function (Builder $query) use ($vacaciones_filter) {
                    $query->whereEstado('LABORANDO');
                });
            }
        }

        if ($request->has('grupo') && is_array($request->get('grupo'))) {
            $queryBase->whereIn('grupo', $request->get('grupo'));
        }

        if ($request->has('search') && $request->get('search') != '') {
            $queryBase->search($request->get('search'));
        }
        return $this->sendResponse($queryBase->paginate(), "Correctamente cargado");
    }

    function create(Request $request)
    {
        $equipo  = Equipo::create($request->all());
        return $this->sendResponse($equipo, "Correctamente creado");
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
