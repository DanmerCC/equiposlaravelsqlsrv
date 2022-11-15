<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use App\Models\Equipo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $resumegrups = Equipo::select('asesors.equipo_id', 'equipos.*', DB::raw('count(*) as total'))
            ->join('asesors', 'asesor_id', '=', 'asesors.id')
            ->whereNotNull('equipos.asesor_id')
            ->whereHas('asesor', function ($query) {
                $query->whereNotNull('equipo_id');
            })
            ->groupBy('asesors.equipo_id');

        $resumegrups = $resumegrups->get();
        $resumegrups->load('asesor.equipo');

        //dd($resumegrups);

        $noAsign = Equipo::whereNull('asesor_id')->count();
        $asign = Equipo::whereNotNull('asesor_id')->count();
        $malogrados = Equipo::whereEstado('MALOGRADO')->count();
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
            'malogrados' => $malogrados,
        ]);
    }
    public function equipos()
    {
        return view('equipos');
    }
    public function usuarios()
    {
        return view('usuarios');
    }
    public function asesores()
    {
        return view('asesores');
    }
    public function graficos()
    {
        $resumegrups = DB::table('equipos')
            ->select('grupo', DB::raw('count(*) as total'))
            ->join('asesors', 'asesor_id', '=', 'asesors.id')
            ->groupBy('grupo')->get();
        $equipos = Asesor::select('equipo_id', DB::raw('count(*) as total'))->groupBy('equipo_id')->whereNotNull('equipo_id')->get();
        $equipos->load('equipo');

        $resumeDiscos = DB::table('equipos')
            ->select('tipo_disco', DB::raw('count(*) as total'))
            ->join('asesors', 'asesor_id', '=', 'asesors.id')
            ->groupBy('tipo_disco')
            ->get();
        //dd($resumeDiscos);
        return view('graficos', [
            'data' => $resumegrups,
            "resumeDiscos" => $resumeDiscos,
            "equipos" => $equipos
        ]);
    }
    public function about()
    {
        return view('without');
    }
}
