<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ==== Controllers ====
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\LoanController as AdminLoanController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\User\LoanController as UserLoanController;

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
    // Dashboard user
    Route::get('/dashboard', fn () => view('user.dashboard'))->name('dashboard');

    // Profile
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');

    // Loans (User)
    Route::get('/loans/create', [UserLoanController::class, 'create'])->name('loans.create');
    Route::post('/loans',        [UserLoanController::class, 'store'])->name('loans.store');
    Route::get('/loans/mine',    [UserLoanController::class, 'mine'])->name('loans.mine');
});

// ================== ADMIN ROUTES ==================
Route::middleware(['auth', 'isAdmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Manajemen Ruangan (CRUD)
        Route::get('/rooms', [RoomController::class,'index'])->name('rooms');
        Route::post('/rooms', [RoomController::class,'store'])->name('store');
        Route::put('/rooms/{room}', [RoomController::class,'update'])->name('update');
        Route::delete('/rooms/{room}', [RoomController::class,'destroy'])->name('destroy');

        // Loans (moderasi admin)
        Route::get('loans', [AdminLoanController::class, 'index'])->name('loans.index');
        Route::put('loans/{loan}/approve', [AdminLoanController::class, 'approve'])->name('loans.approve');
        Route::put('loans/{loan}/reject',  [AdminLoanController::class, 'reject'])->name('loans.reject');

        // Jadwal & Statistik
        Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule');
        Route::get('stats',    [StatsController::class, 'index'])->name('stats');

        // Manage User (index/store/update/destroy)
        Route::resource('manageuser', ManageUserController::class)->names([
            'index' => 'manageuser',
        ])->except(['create','edit','show']);

        // Notifications (AJAX polling)
        Route::get('/notifications/latest', [DashboardController::class, 'latestNotifications'])
            ->name('notifications.latest');
    });

// ================== AUTH ROUTES ==================
require __DIR__ . '/auth.php';
