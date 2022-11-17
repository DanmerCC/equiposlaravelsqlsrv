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
        $resumegrupsFromEquipos = DB::table('equipos')
            ->select('grupo', DB::raw('count(*) as total'))
            ->join('asesors', 'asesor_id', '=', 'asesors.id')
            ->groupBy('grupo')->get();
        DB::enableQueryLog();
        $resumegrups = Equipo::select('supervisor_id', DB::raw('count(*) as total'))
        ->groupBy('supervisor_id')
        ->whereNotNull('supervisor_id')
        ->whereHas('supervisor',function($query){
            $query->where('dni', 'not like',"bot%");
            $query->orWhere('dni', 'not like',"%bot%");
            $query->orWhere('dni', 'not like',"%bot");

        })
        ->get();

        $equipos = Asesor::select('equipo_id', DB::raw('count(*) as total'))->groupBy('equipo_id')->whereNotNull('equipo_id')->get();
        $equipos->load('equipo');
        $resumegrups->load('supervisor');
        $resumeDiscos = DB::table('equipos')
            ->select('tipo_disco', DB::raw('count(*) as total'))
            ->join('asesors', 'asesor_id', '=', 'asesors.id')
            ->groupBy('tipo_disco')
            ->get();
        $resumeProcesador = Equipo::select('procesador', DB::raw('count(*) as total'))->groupBy('procesador')->whereNotNull('procesador')->get();
        //dd($resumegrups->toArray());
        return view('graficos', [
            'data' => $resumegrups,
            "resumeDiscos" => $resumeDiscos,
            "resumeProcesador" => $resumeProcesador,
            "equipos" => $equipos,
            "resumegrups" => $resumegrups
        ]);
    }
    public function about()
    {
        return view('without');
    }
}
