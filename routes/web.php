<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\NotificationController;
// Controladores de Auth são carregados via auth.php, mas se precisar explícito:
// use App\Http\Controllers\Auth\RegisteredUserController;
// use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui é onde você pode registrar as rotas web para sua aplicação.
|
*/

// Rota pública inicial: Redireciona para o login se não autenticado
Route::get('/', fn() => redirect()->route('login'));

// Grupo de rotas protegidas (Requer apenas autenticação)
Route::middleware(['auth'])->group(function () {

    // --- Dashboard ---
    // Acessível em /dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- Relatórios ---
    // Unificado para usar o ReportController. Acessível em /reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // --- Chamados (Tickets) ---
    // Cria automaticamente todas as rotas CRUD: index, create, store, show, edit, update, destroy
    Route::resource('tickets', TicketController::class);

    // --- Categorias ---
    // Apenas permissão para criar e deletar (geralmente via admin ou ajax)
    Route::resource('categories', CategoryController::class)->only(['store', 'destroy']);

    // --- Perfil do Usuário ---
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // --- Notificações ---
    Route::prefix('notifications')->name('notifications.')->group(function () {
        // Listagem
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        
        // Ações em lote ou estáticas (devem vir antes das rotas com {id})
        Route::patch('/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-as-read');
        Route::get('/unread', [NotificationController::class, 'getUnreadNotifications'])->name('unread');
        
        // Ações em itens específicos
        Route::patch('/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('mark-as-read');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
    });

    // --- Área Administrativa ---
    // Protegida pelo Gate ou Middleware 'can:admin'
    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/config', [AdminUserController::class, 'index'])->name('config');
        Route::get('/settings', [AdminUserController::class, 'settings'])->name('settings');
        
        // Gerenciamento de usuários
        Route::resource('users', AdminUserController::class)->except(['show']);
        
        // Rota específica para alternar status de admin
        Route::patch('/users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])
             ->name('users.toggle-admin');
    });
});

// Rotas de Autenticação (Login, Registro, Recuperação de Senha, etc.)
// Certifique-se de que o arquivo auth.php existe na pasta routes
require __DIR__.'/auth.php';