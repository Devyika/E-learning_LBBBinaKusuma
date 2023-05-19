<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\{
    DashboardAdminController,
    UserAdminController,
    UserGuruController,
    UserSiswaController,
    JurusanController,
    KelasController,
    MapelController,
};

use App\Http\Controllers\Guru\{
    DashboardGuruController,
    PertemuanController,
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

Route::get('/', [HomeController::class, 'index']);

Route::get('/logout', [LoginController::class, 'logout']);

Route::middleware(['auth', 'IsAdmin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index']);
    Route::resource('user', UserController::class);
    Route::resource('user-admin', UserAdminController::class);
    Route::resource('user-guru', UserGuruController::class);
    Route::resource('user-siswa', UserSiswaController::class);
    Route::resource('sekolah-jurusan', JurusanController::class);
    Route::resource('sekolah-kelas', KelasController::class);
    //Route::resource('sekolah-tingkat', TingkatController::class);
    Route::resource('sekolah-mata_pelajaran', MapelController::class);
});

Route::middleware(['auth', 'IsGuru'])->prefix('guru')->group(function () {
    Route::get('/dashboard', [DashboardGuruController::class, 'index']);
    Route::resource('pertemuan', PertemuanController::class);
    Route::post('/pertemuan/{pertemuan}', [PertemuanController::class, 'store_pertemuan']);
});

Route::middleware(['auth', 'IsSiswa'])->prefix('siswa')->group(function () {
    Route::get('/dashboard', [DashboardSiswaController::class, 'index']);
});
