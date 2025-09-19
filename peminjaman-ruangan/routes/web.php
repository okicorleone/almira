<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ==== Controllers ====
// Admin
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\Admin\NotificationController;

// User
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\User\LoanController as UserLoanController;
use App\Http\Controllers\User\UserDashboardController;

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
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Halaman form ubah password user
    Route::get('/change-password', [UserProfileController::class, 'showChangePasswordForm'])->name('user.password.change');
    Route::put('/change-password', [UserProfileController::class, 'changePassword'])->name('user.password.update');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Loans (User)
    Route::get('/loans/create', [UserLoanController::class, 'create'])->name('loans.create');
    Route::post('/loans', [UserLoanController::class, 'store'])->name('loans.store');
    Route::get('/loans/mine', [UserLoanController::class, 'mine'])->name('loans.mine');
});

// ================== ADMIN ROUTES ==================
Route::middleware(['auth', 'isAdmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {



        Route::get('admin/change-password', [AdminProfileController::class, 'showChangePasswordForm'])->name('password.change');
        Route::put('admin/change-password', [AdminProfileController::class, 'changePassword'])->name('password.update');


        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Manajemen Ruangan (CRUD)
        Route::resource('rooms', RoomController::class);

        // Loans (moderasi admin)
        Route::resource('loans', LoanController::class);
        Route::put('loans/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve');
        Route::put('loans/{loan}/reject', [LoanController::class, 'reject'])->name('loans.reject');

        // Jadwal & Statistik
        Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule');
        Route::get('stats', [StatsController::class, 'index'])->name('stats');

        // Manage User
        Route::resource('manageuser', ManageUserController::class);

        // Notifications (AJAX polling)
        Route::get('/notifications/latest', [NotificationController::class, 'latest'])->name('notifications.latest');
        Route::put('/notifications/read', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');

        // Export schedule CSV
        Route::get('/schedule/export-csv', [ScheduleController::class, 'exportCsv'])->name('schedule.exportCsv');
        
    });

// ================== AUTH ROUTES ==================
require __DIR__ . '/auth.php';
