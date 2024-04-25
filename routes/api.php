<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProyectoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::get('user/{token}',[ProyectoController::class, 'user'])->name('proyecto.user');
Route::put('guardar-diagrama/{codigo}',[ProyectoController::class, 'guardar'])->name('proyecto.guardar');
Route::get('cargar-diagrama/{codigo}',[ProyectoController::class, 'cargarDiagrama'])->name('proyecto.cargar');
Route::post('save',[ProyectoController::class, 'save'])->name('proyecto.save');
