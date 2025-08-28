<?php

use App\Http\Controllers\ReceitaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('register', [RegisterController::class, 'tela_cadastro'])->name('register');
Route::get('login', [RegisterController::class, 'tela_login'])->name('login');
Route::get('receita', [ReceitaController::class, 'index'])->name('receita');



Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
