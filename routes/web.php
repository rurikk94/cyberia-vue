<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NegocioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\TrabajoController;
use App\Http\Controllers\AgendamientoController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\NegocioMaterialController;
use App\Http\Controllers\MetadatosClienteController;
use App\Http\Controllers\MetadatosUsuarioController;
use App\Http\Controllers\TrabajoMaterialController;
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
    return Inertia::render('Dashboard');
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard.i');

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

Route::get('/profile',[MetadatosUsuarioController::class, 'index'])->middleware(['auth', 'verified'])->name('profile');
Route::post('/profile/metadato',[MetadatosUsuarioController::class, 'store'])->middleware(['auth', 'verified'])->name('profile.metadato.add');
Route::put('/profile/{id}/metadato',[MetadatosUsuarioController::class, 'update'])->middleware(['auth', 'verified'])->name('profile.metadato.update');
Route::put('/profile/{id}/nombre',[MetadatosUsuarioController::class, 'update_nombre'])->middleware(['auth', 'verified'])->name('profile.nombre.update');
Route::delete('/profile/{id}/metadato', [MetadatosUsuarioController::class, 'destroy'])->middleware(['auth', 'verified'])->name('profile.metadato.delete');

Route::get('/trabajos',[TrabajoController::class, 'index'])->middleware(['auth', 'verified'])->name('trabajos');
Route::post('/trabajo',[TrabajoController::class, 'store'])->middleware(['auth', 'verified'])->name('trabajo.add');
Route::delete('/trabajo/{id}',[TrabajoController::class, 'destroy'])->middleware(['auth', 'verified'])->name('trabajo.delete');
Route::get('/trabajo/{id}',[TrabajoController::class, 'show'])->middleware(['auth', 'verified'])->name('trabajos.show');
Route::put('/trabajo/{id}/nombre',[TrabajoController::class, 'update_nombre'])->middleware(['auth', 'verified'])->name('trabajo.nombre.update');
Route::put('/trabajo/{id}/descripcion',[TrabajoController::class, 'update_descripcion'])->middleware(['auth', 'verified'])->name('trabajo.descripcion.update');
Route::put('/trabajo/{id}/ubicacion',[TrabajoController::class, 'update_ubicacion'])->middleware(['auth', 'verified'])->name('trabajo.ubicacion.update');
Route::put('/trabajo/{id}/potencia',[TrabajoController::class, 'update_potencias'])->middleware(['auth', 'verified'])->name('trabajo.potencias.update');
Route::delete('/trabajo/{id}/potencia',[TrabajoController::class, 'destroy_potencia'])->middleware(['auth', 'verified'])->name('trabajo.potencias.delete');
Route::get('/trabajo/documento/{id}',[DocumentoController::class, 'show'])->middleware(['auth', 'verified'])->name('trabajo.documento.show');
Route::get('/trabajo/documento/{id}/{codigo_trabajo}',[DocumentoController::class, 'show_cliente'])->middleware(['guest'])->name('trabajo.cliente.documento.show');
Route::post('/trabajo/{id}/documento',[DocumentoController::class, 'store'])->middleware(['auth', 'verified'])->name('trabajo.documento.add');
Route::delete('/trabajo/{id}/documento',[DocumentoController::class, 'destroy'])->middleware(['auth', 'verified'])->name('trabajo.documento.delete');

Route::get('/agenda',[AgendamientoController::class, 'index'])->middleware(['auth', 'verified'])->name('agenda');
Route::get('/calendario',[AgendamientoController::class, 'calendario'])->middleware(['auth', 'verified'])->name('calendario');
Route::post('/agenda',[AgendamientoController::class, 'store'])->middleware(['auth', 'verified'])->name('agenda.add');
Route::delete('/agenda/{id}',[AgendamientoController::class, 'destroy'])->middleware(['auth', 'verified'])->name('agenda.delete');

Route::get('/trabajo',[TrabajoController::class, 'show_estado'])->middleware(['guest'])->name('trabajo.estado.show');
Route::post('/trabajo/estado',[TrabajoController::class, 'get_estado'])->middleware(['guest'])->name('trabajos.estado.get');

Route::post('/trabajo/material',[TrabajoMaterialController::class, 'store'])->middleware(['auth', 'verified'])->name('trabajo.material.add');
Route::put('/trabajo/{id}/material',[TrabajoMaterialController::class, 'update'])->middleware(['auth', 'verified'])->name('trabajo.material.update');
Route::delete('/trabajo/{id}/material',[TrabajoMaterialController::class, 'destroy'])->middleware(['auth', 'verified'])->name('trabajo.material.delete');

require __DIR__.'/auth.php';
