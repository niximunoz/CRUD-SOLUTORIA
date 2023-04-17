<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndicadoresController;

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
Route::get('indicadores/mostrar',[IndicadoresController::class,'mostrar'])
->name('indicadores.mostrar');

Route::get('indicadores',[IndicadoresController::class,'index'])
->name('indicadores.index');

Route::post('indicadores',[IndicadoresController::class,'registrar'])
->name('indicadores.registrar');

Route::get('indicadores/eliminar/{id}',[IndicadoresController::class,'eliminar'])
->name('indicadores.eliminar');

Route::get('indicadores/editar/{id}',[IndicadoresController::class,'editar'])
->name('indicadores.editar');

Route::post('indicadores/actualizar',[IndicadoresController::class,'actualizar'])
->name('indicadores.actualizar');

Route::get('indicadores/eliminarAll/',[IndicadoresController::class,'eliminarAll'])
->name('indicadores.eliminarAll');

