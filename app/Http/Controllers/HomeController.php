<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use App\Models\Equipo;
use App\Models\Movil;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $disponibles = Equipo::whereNull('asesor_id')->whereEstado('OPERATIVO')->count();
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
            'disponibles' => $disponibles,
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
    public function actas()
    {
        return view('actas');
    }

    public function actaequipo($id,Request $request){
        $equipo = Equipo::find($id);

        $inputs = $request->only(['fecha','local','fecha_entrega','tipo_asignacion']);
        $inputs["equipo"] = $equipo;
        $inputs["apellidos"] = $equipo->asesor==null?"":$equipo->asesor->apellido_paterno." ".$equipo->asesor->apellido_materno;
        $inputs["nombres"] = $equipo->asesor==null?"":$equipo->asesor->nombres;
        $inputs["dni"] = $equipo->asesor==null?"":$equipo->asesor->dni;

        $pdf = Pdf::loadView('pdf.actaequipo', $inputs);
        return $pdf->stream('invoice.pdf');
    }
    public function actaMovil($id,Request $request){
        $equipo = Movil::find($id);

        $inputs = $request->only(['fecha','local','fecha_entrega','tipo_asignacion']);
        $inputs["movil"] = $equipo;
        $inputs["apellidos"] = $equipo->asesor==null?"":$equipo->asesor->apellido_paterno." ".$equipo->asesor->apellido_materno;
        $inputs["nombres"] = $equipo->asesor==null?"":$equipo->asesor->nombres;
        $inputs["dni"] = $equipo->asesor==null?"":$equipo->asesor->dni;

        $pdf = Pdf::loadView('pdf.actamovil', $inputs);
        return $pdf->stream('invoice.pdf');
    }

    public function graficos()
    {
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


        $resumentAntiguedad = Equipo::select(DB::raw('COUNT(*) AS total'),DB::raw('TIMESTAMPDIFF(YEAR, fecha_compra, CURDATE()) AS years'))->groupBy('years')->get();
        //dd($resumentAntiguedad->toArray());
        return view('graficos', [
            'data' => $resumegrups,
            "resumeDiscos" => $resumeDiscos,
            "resumeProcesador" => $resumeProcesador,
            "equipos" => $equipos,
            "resumegrups" => $resumegrups,
            "resumentAntiguedad" => $resumentAntiguedad,
        ]);
    }

    public function actasnew(Request $request)
    {
        $pdf = Pdf::loadView('pdf.acta', $request->all());
        return $pdf->stream('invoice.pdf');
    }
    public function about()
    {
        return view('without');
    }

    public function moviles()
    {
        return view('moviles');
    }

}
