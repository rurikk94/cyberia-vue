<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NegocioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\NegocioMaterialController;
use App\Http\Controllers\MetadatosClienteController;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/negocios', [NegocioController::class, 'index'])->middleware(['auth', 'verified'])->name('negocios');
Route::post('/negocios', [NegocioController::class, 'store'])->middleware(['auth', 'verified'])->name('negocios.add');
Route::delete('/negocios/{id}', [NegocioController::class, 'destroy'])->middleware(['auth', 'verified'])->name('negocios.delete');
Route::put('/negocios/{id}', [NegocioController::class, 'update'])->middleware(['auth', 'verified'])->name('negocios.update');

Route::get('/clientes',[ClienteController::class, 'index'])->middleware(['auth', 'verified'])->name('clientes');
Route::get('/clientes/{id}',[ClienteController::class, 'show'])->middleware(['auth', 'verified'])->name('clientes.show');
Route::post('/clientes',[ClienteController::class, 'store'])->middleware(['auth', 'verified'])->name('clientes.add');
Route::delete('/clientes/{id}',[ClienteController::class, 'destroy'])->middleware(['auth', 'verified'])->name('clientes.delete');
Route::put('/clientes/{id}',[ClienteController::class, 'update'])->middleware(['auth', 'verified'])->name('clientes.update');


Route::get('/materiales',[MaterialController::class, 'index'])->middleware(['auth', 'verified'])->name('materiales');
Route::post('/materiales',[MaterialController::class, 'store'])->middleware(['auth', 'verified'])->name('materiales.add');
Route::delete('/materiales/{id}',[MaterialController::class, 'destroy'])->middleware(['auth', 'verified'])->name('materiales.delete');
Route::put('/materiales/{id}',[MaterialController::class, 'update'])->middleware(['auth', 'verified'])->name('materiales.update');

Route::get('/negocios/{id}/material', [NegocioMaterialController::class, 'show'])->middleware(['auth', 'verified'])->name('negocios.material');
Route::post('/negocios/{id}/material', [NegocioMaterialController::class, 'store'])->middleware(['auth', 'verified'])->name('negocios.material.add');
Route::delete('/negocios/material/{id}', [NegocioMaterialController::class, 'destroy'])->middleware(['auth', 'verified'])->name('negocios.material.delete');
Route::put('/negocios/material/{id}', [NegocioMaterialController::class, 'update'])->middleware(['auth', 'verified'])->name('negocios.material.update');

Route::post('/clientes/metadato',[MetadatosClienteController::class, 'store'])->middleware(['auth', 'verified'])->name('clientes.metadato.add');
Route::put('/clientes/{id}/metadato',[MetadatosClienteController::class, 'update'])->middleware(['auth', 'verified'])->name('clientes.metadato.update');
Route::delete('/clientes/{id}/metadato', [MetadatosClienteController::class, 'destroy'])->middleware(['auth', 'verified'])->name('clientes.metadato.delete');

require __DIR__.'/auth.php';
