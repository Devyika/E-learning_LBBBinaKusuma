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
    AdminJurusanController,
    AdminKelasController,
    AdminTingkatController,
    AdminPertemuanController,
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
    Route::resource('/dashboard', DashboardAdminController::class);
    Route::resource('user', UserController::class);
    Route::resource('input-admin', UserAdminController::class);
    Route::resource('input-guru', UserGuruController::class);
    Route::resource('input-siswa', UserSiswaController::class);
    Route::resource('input-jurusan', AdminJurusanController::class);
    Route::resource('input-kelas', AdminKelasController::class);
    Route::resource('input-tingkat', AdminTingkatController::class);
    Route::resource('input-pertemuan', AdminPertemuanController::class);
    Route::resource('input-mata_pelajaran', MapelController::class);
    Route::get('setting-kelas/{t}/{j}', [AdminKelasController::class, 'jurusanTingkatKelas_index']);
    Route::post('setting-kelas/{t}/{j}', [AdminKelasController::class, 'jurusanTingkatKelas_store']);
    Route::put('setting-kelas/{id}', [AdminKelasController::class, 'jurusanTingkatKelas_update']);
    Route::delete('setting-kelas/{id}', [AdminKelasController::class, 'jurusanTingkatKelas_destroy']);
    Route::get('setting-mata_pelajaran/{t}/{j}', [MapelController::class, 'kelasMapel_index']);
    Route::post('setting-mata_pelajaran/{t}/{j}', [MapelController::class, 'kelasMapel_store']);
    Route::put('setting-mata_pelajaran/{id}', [MapelController::class, 'kelasMapel_update']);
    Route::delete('setting-mata_pelajaran/{id}', [MapelController::class, 'kelasMapel_destroy']);
    Route::get('setting-siswa/{t}/{j}', [UserSiswaController::class, 'kelasSiswa_index']);
    Route::post('setting-siswa/{t}/{j}', [UserSiswaController::class, 'kelasSiswa_store']);
    Route::put('setting-siswa/{id}', [UserSiswaController::class, 'kelasSiswa_update']);
    Route::delete('setting-siswa/{id}', [UserSiswaController::class, 'kelasSiswa_destroy']);
});

Route::middleware(['auth', 'IsGuru'])->prefix('guru')->group(function () {
    Route::get('/dashboard', [DashboardGuruController::class, 'index']);
    Route::resource('pertemuan', PertemuanController::class);
    Route::post('/pertemuan/{pertemuan}', [PertemuanController::class, 'store_pertemuan']);
    Route::post('/pertemuan/modul/{pertemuan}/{id}', [PertemuanController::class, 'store_modul']);
    Route::post('/pertemuan/tugas/{pertemuan}/{id}', [PertemuanController::class, 'store_tugas']);
});

Route::middleware(['auth', 'IsSiswa'])->prefix('siswa')->group(function () {
    Route::get('/dashboard', [DashboardSiswaController::class, 'index']);
});
