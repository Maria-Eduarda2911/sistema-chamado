<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rota pública inicial
Route::get('/', fn() => view('welcome'));

// Auth público
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

// Rotas protegidas
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/reports', [DashboardController::class, 'generateReport'])->name('reports');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('tickets', TicketController::class);
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/config', [AdminUserController::class, 'index'])->name('config');
        Route::get('/settings', [AdminUserController::class, 'settings'])->name('settings');
        Route::resource('users', AdminUserController::class)->except(['show']);
        Route::patch('/users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])
             ->name('users.toggle-admin');
    });
});

// Categorias + Relatório (apenas auth)
Route::middleware('auth')->group(function () {
    Route::resource('categories', CategoryController::class)->only(['store','destroy']);
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    
    // Rotas de notificações
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::patch('/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('mark-as-read');
        Route::patch('/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-as-read');
        Route::get('/unread', [NotificationController::class, 'getUnreadNotifications'])->name('unread');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
    });
});

// Rotas de logout, password reset etc.
require __DIR__.'/auth.php';
