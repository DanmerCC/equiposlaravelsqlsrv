<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $resumegrups = DB::table('equipos')->select('grupo', DB::raw('count(*) as total'))->groupBy('grupo')->get();
        $noAsign = Equipo::whereNull('asesor_id')->count();
        $asign = Equipo::whereNotNull('asesor_id')->count();
        $total = Equipo::count();
        $vacaciones = Equipo::whereHas('asesor', function (Builder $query) {
            $query->whereEstado('VACACIONES');
        })->count();
        $laborando = Equipo::whereHas('asesor', function (Builder $query) {
            $query->whereEstado('LABORANDO');
        })->count();
        $total = Equipo::count();


        return view('home', [
            'resumegrups' => $resumegrups,
            'noAsign' => $noAsign,
            'asign' => $asign,
            'total' => $total,
            'vacaciones' => $vacaciones,
            'laborando' => $laborando,
        ]);
    }
    public function equipos()
    {
        return view('equipos');
    }
    public function graficos()
    {
        return view('graficos');
    }
    public function about()
    {
        return view('without');
    }
}
