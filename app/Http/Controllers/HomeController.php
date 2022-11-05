<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        return view('home');
    }
    public function equipos() {
        return view('equipos');
    }
    public function about() {
        return view('without');
    }
}
