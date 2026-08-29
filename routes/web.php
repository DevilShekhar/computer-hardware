<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DesignerDashboardController;
use App\Http\Controllers\RoomPackController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DesignerDashboardController::class, 'index'])->name('dashboard');
    Route::resource('room_packs', RoomPackController::class);
});
