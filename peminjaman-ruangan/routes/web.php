<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controller imports
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\LoanController;

// ================== Redirect root & /admin ==================

// Jika akses /admin langsung, redirect ke dashboard admin
Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});

// Root (/) → arahkan sesuai role
Route::get('/', function () {
    if (Auth::check()) {
        // Kalau admin
        if (Auth::user()->role === 'admin') {
            return redirect('/admin/dashboard');
        }
        // Kalau user biasa
        return redirect('/dashboard');
    }
    return redirect('/login');
});

// ================== USER ROUTES ==================
Route::middleware(['auth'])->group(function () {
    // Dashboard untuk User (bukan admin)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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
    Route::put('loans/{loan}/reject', [LoanController::class, 'reject'])->name('loans.reject');
});

// ================== AUTH ROUTES ==================
require __DIR__.'/auth.php';
