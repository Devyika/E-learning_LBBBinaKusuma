<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/login', [LoginController::class, 'index']);
// Route::get('/dashboard', [DashboardController::class, 'index']);

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
Route::get('/', [LoginController::class, 'showLoginForm']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::middleware(['auth'])->group(function() {

    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // Route::redirect('/home', '/dashboard', 301);

    Route::resource('/mahasiswa', MahasiswaController::class)->parameter('mahasiswa', 'id');
});