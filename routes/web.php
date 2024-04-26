<?php
use App\Http\Controllers\ProyectoController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    return redirect(route('login'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home2', [App\Http\Controllers\HomeController::class, 'index2'])->name('home2');

Route::get('/descargar-codigo-java/{codigo}', [ProyectoController::class, 'descargarCodigoJava'])->name('descargarCodigoJava');

Route::get('/descargar-codigo-php/{codigo}', [ProyectoController::class, 'descargarCodigoPhp'])->name('descargarCodigoPhp');

Route::get('/descargar-codigo-python/{codigo}', [ProyectoController::class, 'descargarCodigoPython'])->name('descargarCodigoPython');


