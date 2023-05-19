<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Pertemuan;
use App\Models\Siswa;
use App\Models\Tingkat;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('countAdmin', Admin::count());
        View::share('countGuru', Guru::count());
        View::share('countSiswa', Siswa::count());
        View::share('countJurusan', Jurusan::count());
        View::share('countTingkat', Tingkat::count());
        View::share('countKelas', Kelas::count());
        View::share('countMapel', Mapel::count());
        View::share('countPertemuan', Pertemuan::count());
        View::share('allJurusan', Jurusan::all());
        View::share('allTingkat', Tingkat::all());
    }
}
