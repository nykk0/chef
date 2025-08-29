<?php

use App\Http\Controllers\ReceitaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\InventarioController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('register', [RegisterController::class, 'tela_cadastro'])->name('register');
Route::get('login', [RegisterController::class, 'tela_login'])->name('login');
Route::get('alter_user', [RegisterController::class, 'tela_update'])->name('alter_user');
Route::put('update', [RegisterController::class, 'updateUser'])->name('user.update');

Route::post('logout', [RegisterController::class, 'logout'])->name('logout');

Route::get('receita', [ReceitaController::class, 'index'])->name('receita');

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

// rotas inventario
Route::prefix('inventario')->group(function () {
    Route::get('/', [InventarioController::class, 'index'])->name('inventario.index');
    Route::get('/create', [InventarioController::class, 'create'])->name('inventario.create');
    Route::post('/store', [InventarioController::class, 'store'])->name('inventario.store');
    Route::get('/{inventario}/edit', [InventarioController::class, 'edit'])->name('inventario.edit');
    Route::put('/{inventario}', [InventarioController::class, 'update'])->name('inventario.update');
    Route::delete('/{inventario}', [InventarioController::class, 'destroy'])->name('inventario.destroy');
});
Route::patch('/inventario/{inventario}/entrada', [InventarioController::class, 'entrada'])->name('inventario.entrada');
Route::patch('/inventario/{inventario}/saida', [InventarioController::class, 'saida'])->name('inventario.saida');
