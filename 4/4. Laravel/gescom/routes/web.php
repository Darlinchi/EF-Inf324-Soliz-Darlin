<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// USUARIOS: EDITAR, ELIMINAR, CREAR
Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
Route::resource('usuarios', UsuarioController::class);
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');

// CATEGORIAS: EDITAR, ELIMINAR, CREAR
Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
Route::resource('categorias', CategoriaController::class);
Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');

// PRODUCTOS: EDITAR, ELIMINAR, CREAR
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::resource('productos', ProductoController::class);
Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');

// PEDIDOS: EDITAR, ELIMINAR, CREAR
Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
Route::resource('pedidos', PedidoController::class);
Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
