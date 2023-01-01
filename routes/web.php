<?php

use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);
// Private Routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('view.home');
    Route::get('/equipos', [App\Http\Controllers\HomeController::class, 'equipos'])->name('view.equipos');
    Route::get('/graficos', [App\Http\Controllers\HomeController::class, 'graficos'])->name('view.graficos');
    Route::get('/usuarios', [App\Http\Controllers\HomeController::class, 'usuarios'])->name('view.usuarios');
    Route::get('/asesores', [App\Http\Controllers\HomeController::class, 'asesores'])->name('view.asesores');
    Route::get('/actas', [App\Http\Controllers\HomeController::class, 'actas'])->name('view.actas');
    Route::get('/moviles', [App\Http\Controllers\HomeController::class, 'moviles'])->name('view.moviles');
    Route::get('/actas/new', [App\Http\Controllers\HomeController::class, 'actasnew'])->name('view.actas');
    Route::get('/acta/equipo/{id}', [App\Http\Controllers\HomeController::class, 'actaequipo'])->name('view.actasequipo');
    Route::get('/acta/celular/{id}', [App\Http\Controllers\HomeController::class, 'actaMovil'])->name('view.actamovil');
    Route::get('/without/breadcrumbs', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
});
Route::group(['middleware' => ['auth'], 'prefix' => 'api'], function () {
    Route::get('asesor', [App\Http\Controllers\AsesorController::class, 'list'])->name('asesor');
    Route::put('asesor/{id}', [App\Http\Controllers\AsesorController::class, 'update'])->name('asesor.update');
    Route::delete('asesor/{id}', [App\Http\Controllers\AsesorController::class, 'delete'])->name('asesor.delete');
    Route::post('asesor', [App\Http\Controllers\AsesorController::class, 'create'])->name('asesor.create');

    Route::get('equipos', [App\Http\Controllers\EquipoController::class, 'list'])->name('asesor');
    Route::delete('equipos/{id}', [App\Http\Controllers\EquipoController::class, 'delete'])->name('equipo.delete');
    Route::post('equipos', [App\Http\Controllers\EquipoController::class, 'create'])->name('asesor');
    Route::put('equipos/{id}', [App\Http\Controllers\EquipoController::class, 'update'])->name('asesor.update');

    Route::get('moviles', [App\Http\Controllers\MovilController::class, 'list'])->name('movil.list');
    Route::delete('moviles/{id}', [App\Http\Controllers\MovilController::class, 'delete'])->name('movil.delete');
    Route::post('moviles', [App\Http\Controllers\MovilController::class, 'create'])->name('movil.create');
    Route::put('moviles/{id}', [App\Http\Controllers\MovilController::class, 'update'])->name('movil.update');

    Route::resource('usuarios', UsuarioController::class);
});
Route::fallback(function () {
    abort(404);
});
