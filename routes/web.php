<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\{
    DashboardAdminController,
    MapelController,
    MasterUserController,
};

use App\Http\Controllers\Guru\{
    DashboardGuruController,
};

use App\Http\Controllers\Siswa\{
    DashboardSiswaController,
};

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

Auth::routes();
Route::get('/logout', [LoginController::class, 'logout']);

Route::middleware(['auth', 'IsAdmin'])->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index']);
    Route::resource('master-user', MasterUserController::class);
    Route::resource('mata-pelajaran', MapelController::class);
});

Route::middleware(['auth', 'IsGuru'])->group(function () {
    Route::get('/dashboard', [DashboardGuruController::class, 'index']);
});

Route::middleware(['auth', 'IsSiswa'])->group(function () {
    Route::get('/dashboard', [DashboardSiswaController::class, 'index']);
});
