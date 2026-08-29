<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BuilderBrandController;
use App\Http\Controllers\Admin\BuilderCategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::get('roles/{role}/permissions-data', [RoleController::class, 'getPermissionsData'])->name('roles.permissions.data');
    Route::get('roles/{role}/permissions', [RoleController::class, 'managePermissions'])->name('roles.permissions');
    Route::put('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/users', UserController::class)->names('admin.users');
    Route::resource('builder-brands', BuilderBrandController::class);
    Route::resource('builder-categories', BuilderCategoryController::class);
});