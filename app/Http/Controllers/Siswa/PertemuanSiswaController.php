<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\PengumpulanTugas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PertemuanSiswaController extends Controller
{
    public function show($id)
    {
        DB::statement("SET SQL_MODE=''");
        $username_siswa = Auth::user()->username;

        $userId = Siswa::all()->where('username', $username_siswa)->pluck('id')->first();

        $pertemuanSidebar = DB::table('pertemuan as a')
        ->join('kelas_mapel_guru as b', 'b.id', '=', 'a.id_kelasMapelGuru')
        ->join('kelas_siswa as c', 'c.id_jurusanTingkatKelas', '=', 'b.id_jurusanTingkatKelas')
        ->select('a.id', 'a.nama', 'a.id_kelasMapelGuru', 'b.id_jurusanTingkatKelas', 'b.id_mapel', 'c.id_siswa')
        ->where('id_siswa', $userId)
        ->orderBy('nama')
        ->get();
    
        $pertemuan = DB::table('pertemuan as a')
            ->join('kelas_mapel_guru as b', 'b.id', '=', 'a.id_kelasMapelGuru')
            ->join('mapel as c', 'c.id', '=', 'b.id_mapel')
            ->join('jurusan_tingkat_kelas as d', 'd.id', '=', 'b.id_jurusanTingkatKelas')
            ->join('tingkat as e', 'e.id', '=', 'd.id_tingkat')
            ->join('kelas as f', 'f.id', '=', 'd.id_kelas')
            ->join('jurusan as g', 'g.id', '=', 'd.id_jurusan')
            ->select('a.nama', 'a.id_kelasMapelGuru', 'b.id_mapel', 'c.nama as mapel', 
            'b.id_jurusanTingkatKelas', 'e.name as tingkat', 'g.name as jurusan',
            'f.nama as kelas','a.id')
            ->where('a.id', $id)
            ->get();

        $modul = DB::table('modul as a')
            ->join('pertemuan as b','b.id','=','a.id_pertemuan')
            ->select('a.*')
            ->where('a.id_pertemuan', $id)
            ->get();
        
        $tugas = DB::table('tugas as a')
            ->join('pertemuan as b','b.id','=','a.id_pertemuan')
            ->where('a.id_pertemuan', $id)
            ->select('a.*')
            ->get();

        $user = User::join('siswa', 'users.username', '=', 'siswa.username')
                ->select('users.username', 'siswa.*')
                ->where('users.id', Auth::user()->id)
                ->first();

        return view('siswa.pertemuan')
            ->with('pertemuan', $pertemuan)
            ->with('pertemuanSidebar', $pertemuanSidebar)
            ->with('modul', $modul)
            ->with('user', $user)
            ->with('tugas', $tugas)
            ->with('userId', $userId);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:pdf'], // Menambahkan validasi mime type untuk hanya menerima file PDF
        ]);

        $username_siswa = Auth::user()->username;
        $userId = Siswa::where('username', $username_siswa)->pluck('id')->first(); // Menggunakan "first()" untuk mendapatkan ID siswa tunggal

        $existingSubmission = PengumpulanTugas::where('id_siswa', $userId)
            ->where('id_tugas', $id)
            ->first();

        if ($existingSubmission) {
            // Jika sudah ada pengumpulan sebelumnya oleh $userId, lakukan update file
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $originalFilename = $file->getClientOriginalName();
                $file_name = $file->storeAs('file/tugas', $originalFilename, 'public');

                $existingSubmission->update([
                    'file' => $file_name,
                ]);

                return redirect()->back()->with('success', 'File berhasil diperbarui');
            }
        } else {
            // Jika belum ada pengumpulan sebelumnya oleh $userId, buat entri baru
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $originalFilename = $file->getClientOriginalName();
                $file_name = $file->storeAs('file/tugas', $originalFilename, 'public');

                PengumpulanTugas::create([
                    'id_siswa' => $userId,
                    'id_tugas' => $id,
                    'nilai' => 0,
                    'file' => $file_name,
                ]);

                return redirect()->back()->with('success', 'File berhasil dikumpulkan');
            }
        }

        return redirect()->back()->with('error', 'Terjadi kesalahan dalam mengunggah file');
    }

}
