<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\ProfilePhotoController;
use App\Models\Role;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Public/Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route untuk user biasa dan admin
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard route (akan menampilkan konten berbeda berdasarkan role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/photo', [ProfilePhotoController::class, 'update'])->name('profile.photo.update');
    Route::delete('/profile/photo', [ProfilePhotoController::class, 'destroy'])->name('profile.photo.destroy');

    // Users Management (hanya untuk admin)
    Route::middleware(['role:admin'])->group(function () {
        // Users routes
        Route::controller(UserController::class)->group(function () {
            Route::get('/users', 'index')->name('users.index');
            Route::get('/users/create', 'create')->name('users.create');
            Route::post('/users', 'store')->name('users.store');
            Route::get('/users/{user}/edit', 'edit')->name('users.edit');
            Route::put('/users/{user}', 'update')->name('users.update');
            Route::delete('/users/{user}', 'destroy')->name('users.destroy');
        });
        
        // Permissions routes
        Route::get('/permissions', [App\Http\Controllers\Permissions\PermissionController::class, 'index'])->name('permissions.index');
        
        // Permission Groups routes
        Route::get('/permission-groups/create', [App\Http\Controllers\Permissions\PermissionController::class, 'createGroup'])->name('permission-groups.create');
        Route::post('/permission-groups', [App\Http\Controllers\Permissions\PermissionController::class, 'storeGroup'])->name('permission-groups.store');
        Route::get('/permission-groups/{id}/edit', [App\Http\Controllers\Permissions\PermissionController::class, 'editGroup'])->name('permission-groups.edit');
        Route::put('/permission-groups/{id}', [App\Http\Controllers\Permissions\PermissionController::class, 'updateGroup'])->name('permission-groups.update');
        Route::delete('/permission-groups/{id}', [App\Http\Controllers\Permissions\PermissionController::class, 'destroyGroup'])->name('permission-groups.destroy');
        
        // Permissions routes
        Route::get('/permissions/create', [App\Http\Controllers\Permissions\PermissionController::class, 'createPermission'])->name('permissions.create');
        Route::post('/permissions', [App\Http\Controllers\Permissions\PermissionController::class, 'storePermission'])->name('permissions.store');
        Route::get('/permissions/{id}/edit', [App\Http\Controllers\Permissions\PermissionController::class, 'editPermission'])->name('permissions.edit');
        Route::put('/permissions/{id}', [App\Http\Controllers\Permissions\PermissionController::class, 'updatePermission'])->name('permissions.update');
        Route::delete('/permissions/{id}', [App\Http\Controllers\Permissions\PermissionController::class, 'destroyPermission'])->name('permissions.destroy');
        
        // Roles routes
        Route::get('/roles', [App\Http\Controllers\Permissions\RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [App\Http\Controllers\Permissions\RoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [App\Http\Controllers\Permissions\RoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/{id}/edit', [App\Http\Controllers\Permissions\RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{id}', [App\Http\Controllers\Permissions\RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{id}', [App\Http\Controllers\Permissions\RoleController::class, 'destroy'])->name('roles.destroy');
        Route::post('/roles/{roleId}/permissions', [App\Http\Controllers\Permissions\PermissionController::class, 'assignPermissions'])->name('roles.permissions.assign');
    });
});

require __DIR__.'/auth.php';
