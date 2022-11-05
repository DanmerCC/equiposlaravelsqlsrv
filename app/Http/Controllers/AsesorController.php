<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use Illuminate\Http\Request;

class AsesorController extends Controller
{
    function list(Request $request)
    {
        return $this->sendResponse(Asesor::paginate(), "Correctamente cargado");
    }
}
