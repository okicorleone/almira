<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ==== Controllers ====
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\StatsController;

// ================== Redirect root & /admin ==================
Route::get('/admin', fn () => redirect()->route('admin.dashboard'));

Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect('/admin/dashboard')
            : redirect('/dashboard');
    }
    return redirect('/login');
});

// ================== USER ROUTES ==================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ================== ADMIN ROUTES ==================
Route::middleware(['auth', 'isAdmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard admin
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Manajemen Ruangan (CRUD)
        Route::resource('rooms', RoomController::class);

        // Permintaan Peminjaman (Loans)
        Route::get('loans', [LoanController::class, 'index'])->name('loans.index');
        Route::put('loans/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve');
        Route::put('loans/{loan}/reject',  [LoanController::class, 'reject'])->name('loans.reject');

        // Jadwal Pemakaian
        Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule');

        // Statistik Pemakaian
        Route::get('stats', [StatsController::class, 'index'])->name('stats');
    });

// ================== AUTH ROUTES ==================
require __DIR__ . '/auth.php';
