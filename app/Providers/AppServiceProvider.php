<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\JurusanTingkatKelas;
use App\Models\Kelas;
use App\Models\KelasMapel;
use App\Models\KelasSiswa;
use App\Models\Mapel;
use App\Models\PengumpulanTugas;
use App\Models\Pertemuan;
use App\Models\Siswa;
use App\Models\Tingkat;
use Illuminate\Support\Facades\DB;
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
        View::share('allGuru', Guru::all()->where('hapus', 0));
        View::share('allJurusan', Jurusan::all()->where('hapus', 0));
        View::share('allTingkat', Tingkat::all()->where('hapus', 0));
        View::share('allKelas', Kelas::all()->where('hapus', 0));
        View::share('allMapel', Mapel::all()->where('hapus', 0));
        View::share('allSiswa', Siswa::all()->where('hapus', 0));
        View::share('allSiswaKls', DB::table('siswa')
        ->whereNotIn('id', function ($query) {
            $query->select('id_siswa')
                ->from('kelas_siswa');
        })
        ->where('hapus', 0)
        ->get()
        );
        View::share('allKelasMapel', KelasMapel::all());
        View::share('allKelasSiswa', KelasSiswa::all());
        View::share('allPengumpulanTugas', PengumpulanTugas::all());
        View::share('allJurusanTingkatKelas', JurusanTingkatKelas::all());
    }
}
