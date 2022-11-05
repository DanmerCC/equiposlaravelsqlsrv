<?php

use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\UserController;
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
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/equipos', [App\Http\Controllers\HomeController::class, 'equipos'])->name('view.equipos');
    Route::get('/equipos', [App\Http\Controllers\HomeController::class, 'equipos'])->name('view.equipos');
    Route::get('/without/breadcrumbs', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
});
Route::group(['middleware' => ['auth'], 'prefix' => 'api'], function () {
    Route::get('asesor', [App\Http\Controllers\AsesorController::class, 'list'])->name('asesor');
    Route::get('equipos', [App\Http\Controllers\EquipoController::class, 'list'])->name('asesor');
});
Route::fallback(function () {
    abort(404);
});
