<?php
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// routes/web.php
// routes/web.php
Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});


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

// Dashboard untuk User (bukan admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard untuk Admin + Manajemen Ruangan
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Ruangan (CRUD)
    Route::resource('rooms', \App\Http\Controllers\Admin\RoomController::class);
});


// // Dashboard untuk Admin
// Route::middleware(['auth', 'isAdmin'])->group(function () {
//     Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
// });

require __DIR__.'/auth.php';
