<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

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
    return view('inicio');
});

Route::post('/cadastra-jogador', [\App\Http\Controllers\jogadoresCtl::class , 'set']);
Route::post('/carregar-jogadores', [\App\Http\Controllers\jogadoresCtl::class , 'get']);
Route::post('/carregar-jogadores-select', [\App\Http\Controllers\jogadoresCtl::class , 'getAllPlayersToSelectOptions']);
Route::post('/carregar-jogador', [\App\Http\Controllers\jogadoresCtl::class , 'getOne']);
Route::post('/excluir-jogador', [\App\Http\Controllers\jogadoresCtl::class , 'delete']);
Route::post('/realiza-sorteio', [\App\Http\Controllers\jogadoresCtl::class , 'sorteio']);
