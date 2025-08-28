<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('register', [RegisterController::class, 'tela_cadastro'])->name('register');
Route::get('login', [RegisterController::class, 'tele_login'])->name('login');
Route::post('register', [RegisterController::class, 'register']);
Route::get('login', function() {
    return view('auth.login');
})->name('login');
