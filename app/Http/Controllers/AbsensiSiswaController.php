<?php

namespace App\Http\Controllers;
use App\Models\AbsensiSiswa;
use App\Models\JurusanTingkatKelas;
use App\Models\KelasMapel;
use App\Models\KelasSiswa;
use App\Models\Mapel;
use App\Models\PengumpulanTugas;
use App\Models\Pertemuan;
use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;



class AbsensiSiswaController extends Controller
{
    public function index()
    {
        DB::statement("SET SQL_MODE=''");
        $username_siswa = Auth::user()->username;
        $userId = Siswa::where('username', $username_siswa)->pluck('id')->first();
        $user = User::join('siswa', 'users.username', '=', 'siswa.username')
            ->select('users.username', 'siswa.*')
            ->where('users.id', Auth::user()->id)
            ->first();
        return view('siswa.absensisiswa')->with('user', $user)
        ;
    }
}
