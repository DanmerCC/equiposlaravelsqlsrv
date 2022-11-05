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
}
