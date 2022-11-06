<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $resumegrups = DB::table('equipos')->select('grupo', DB::raw('count(*) as total'))->groupBy('grupo')->get();
        return view('home', ['data' => $resumegrups]);
    }
    public function equipos()
    {
        return view('equipos');
    }
    public function about()
    {
        return view('without');
    }
}
