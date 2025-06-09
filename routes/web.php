<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', UserController::class);
    Route::get('users/{user}/view-modal', [UserController::class, 'viewModal'])->name('users.view-modal');
    Route::get('users/{user}/edit-modal', [UserController::class, 'editModal'])->name('users.edit-modal');
    Route::match(['post', 'put'], 'users/{user}/status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('users/listar', [UserController::class, 'listar'])->name('users.listar');

    Route::resource('roles', RoleController::class);
    Route::post('roles/listar', [RoleController::class, 'listar'])->name('roles.listar');

    Route::get('/admin', function () {
        return view('dashboard');
    })->middleware('role:admin')->name('admin.dashboard');
});

require __DIR__.'/auth.php';
