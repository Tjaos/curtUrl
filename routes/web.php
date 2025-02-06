<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

// Rota para a página inicial
Route::get('/', function () {
    return view('welcome');
});

// Dashboard protegido por autenticação
Route::get('/dashboard', [UrlController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rotas de autenticação
Route::get('/login', [ProfileController::class, 'showLoginForm'])->name('login'); // Rota para exibir o formulário de login
Route::post('/login', [ProfileController::class, 'login'])->name('login.post'); // Rota para processar o login

// Rota para exibir o formulário de registro
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register'); // Rota para exibir o formulário de registro
// Rota para processar o registro
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.post'); // Rota para processar o registro



Route::middleware('auth')->group(function () {
    // Gerenciar perfil do usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas para encurtamento de links
    Route::post('/urls', [UrlController::class, 'create'])->name('urls.create'); 
    Route::delete('/urls/{id}', [UrlController::class, 'destroy'])->name('urls.delete');
});

// Rota pública para redirecionamento de URLs curtas
Route::get('/{shortUrl}', [UrlController::class, 'redirect'])->name('urls.redirect');

require __DIR__.'/auth.php';