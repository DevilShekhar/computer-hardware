<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BuilderBrandController;
use App\Http\Controllers\Admin\BuilderCategoryController;
use App\Http\Controllers\Admin\BuilderSubCategoryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/my-change-password', [ProfileController::class, 'changePassword'])->name('password.index');
    Route::post('/my-change-password/verify', [ProfileController::class, 'verifyOldPassword'])->name('password.verify');
    Route::get('/my-change-password/new', [ProfileController::class, 'newPassword'])->name('password.new');
    Route::post('/my-change-password/update', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::resource('roles', RoleController::class);
    Route::get('roles/{role}/permissions-data', [RoleController::class, 'getPermissionsData'])->name('roles.permissions.data');
    Route::get('roles/{role}/permissions', [RoleController::class, 'managePermissions'])->name('roles.permissions');
    Route::put('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/users', UserController::class)->names('admin.users');
    Route::resource('builder-brands', BuilderBrandController::class);
    Route::resource('builder-categories', BuilderCategoryController::class);
    Route::resource('builder-sub-categories',BuilderSubCategoryController::class);
    Route::get('builder-sub-categories/categories-by-brand/{brand}', [BuilderSubCategoryController::class, 'getByBrand'])->name('builder-sub-categories.categories-by-brand');
    Route::resource('categories', CategoryController::class);
});