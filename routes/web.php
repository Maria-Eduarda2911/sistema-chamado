<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rota pública inicial
Route::get('/', function () {
    return view('welcome');
});

// Rotas Públicas de Autenticação (apenas para visitantes)
Route::middleware('guest')->group(function () {
    // Registro
    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');
    
    Route::post('/register', [RegisteredUserController::class, 'store']);

    // Login
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
});

// Rotas Protegidas (requerem autenticação e verificação de e-mail)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Chamados
    Route::resource('tickets', TicketController::class);

    // Perfil do Usuário
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Administração
    Route::middleware(['can:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            // Configurações
            Route::get('/config', [AdminUserController::class, 'index'])
                ->name('config');
            
            Route::get('/settings', [AdminUserController::class, 'settings'])
                ->name('settings');

            // Gestão de Usuários
            Route::resource('users', AdminUserController::class)
                ->except(['show']);
            
            Route::patch('/users/{user}/toggle-admin', 
                [AdminUserController::class, 'toggleAdmin'])
                ->name('users.toggle-admin');
        });
});

// Categorias (protegidas por autenticação)
Route::middleware(['auth'])->group(function () {
    Route::resource('categories', CategoryController::class)
        ->only(['store', 'destroy']);
});

// Rotas de autenticação padrão do Laravel
require __DIR__.'/auth.php';