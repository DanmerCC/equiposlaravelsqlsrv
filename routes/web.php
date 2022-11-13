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
    Route::get('/without/breadcrumbs', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
});
Route::group(['middleware' => ['auth'], 'prefix' => 'api'], function () {
    Route::get('asesor', [App\Http\Controllers\AsesorController::class, 'list'])->name('asesor');
    Route::put('asesor/{id}', [App\Http\Controllers\AsesorController::class, 'update'])->name('asesor.update');
    Route::get('equipos', [App\Http\Controllers\EquipoController::class, 'list'])->name('asesor');
    Route::post('equipos', [App\Http\Controllers\EquipoController::class, 'create'])->name('asesor');
    Route::put('equipos/{id}', [App\Http\Controllers\EquipoController::class, 'update'])->name('asesor.update');
    Route::resource('usuarios', UsuarioController::class);
});
Route::fallback(function () {
    abort(404);
});
