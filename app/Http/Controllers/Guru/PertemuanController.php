<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Modul;
use App\Models\Pertemuan;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PertemuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function store_pertemuan(Request $request, $id)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
        ]);

        Pertemuan::create([
            'nama' => $request->input('nama'),
            'id_kelasMapelGuru' => $id
        ]);

        return redirect('guru/pertemuan/'.$id)->with('success', 'User Berhasil Ditambahkan');
    }

    public function store_tugas(Request $request, $pertemuan, $id)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
        ]);

        Tugas::create([
            'nama' => $request->input('nama'),
            'id_pertemuan' => $id
        ]);

        return redirect('guru/pertemuan/'.$pertemuan)->with('success', 'User Berhasil Ditambahkan');
    }

    public function store_modul(Request $request, $pertemuanId, $id)
    {
        $username = Auth::user()->username;

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'file' => ['required'],
        ]);

        if ($request->file('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = 'modul-'. $username . '-' . $request->input('nama') . '.' . $extension;
            $image_name = $file->storeAs('file/modul', $filename, 'public');
        }        

        Modul::create([
            'nama' => $request->input('nama'),
            'id_pertemuan' => $id,
            'file' => $image_name,
        ]);

        return redirect('guru/pertemuan/'.$pertemuanId)->with('success', 'User Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pertemuan  $pertemuan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id_guru = Auth::user()->username;

        $userId = Guru::all()->where('username', $id_guru)->pluck('id');
    
        $kelas = DB::table('kelas_mapel_guru as a')
            ->join('jurusan_tingkat_kelas as b', 'a.id_jurusanTingkatKelas', '=', 'b.id')
            ->join('kelas as c', 'b.id_kelas', '=', 'c.id')
            ->join('jurusan as d', 'b.id_jurusan', '=', 'd.id')
            ->join('tingkat as e', 'b.id_tingkat', '=', 'e.id')
            ->select('c.nama as kelas','d.name as jurusan','e.name as tingkat', 'b.id as id_kelas')
            ->where('id_guru', $userId)
            ->groupBy('id_jurusanTingkatKelas')
            ->orderBy('nama')
            ->get();
        
        $mapel = DB::table('kelas_mapel_guru as a')
            ->join('mapel as b', 'a.id_mapel', '=', 'b.id')
            ->select('b.nama as nama','a.id_jurusanTingkatKelas as kelas', 'a.id_mapel as id_mapel', 'a.id as id')
            ->where('id_guru', $userId)
            ->get();

        $mapel2 = DB::table('kelas_mapel_guru as a')
        ->join('mapel as b', 'a.id_mapel', '=', 'b.id')
        ->join('jurusan_tingkat_kelas as c', 'c.id', '=', 'a.id_jurusanTingkatKelas')
        ->join('kelas as d', 'd.id', '=', 'c.id_kelas')
        ->join('jurusan as e', 'e.id', '=', 'c.id_jurusan')
        ->join('tingkat as f', 'f.id', '=', 'c.id_tingkat')
        ->select('b.nama','a.id', 'd.nama as kelas', 'e.name as jurusan', 'f.name as tingkat')
        ->where('a.id', $id)
        ->get();

        $modul = DB::table('pertemuan')
        ->join('modul', 'modul.id_pertemuan', '=', 'pertemuan.id')
        ->select('modul.nama as nama', 'modul.file', 'modul.id_pertemuan as id_pertemuan')
        ->where('pertemuan.id_kelasMapelGuru', $id)
        ->get();

        $tugas = DB::table('pertemuan')
        ->join('tugas', 'tugas.id_pertemuan', '=', 'pertemuan.id')
        ->select('tugas.nama as nama', 'tugas.id_pertemuan as id_pertemuan')
        ->where('pertemuan.id_kelasMapelGuru', $id)
        ->get();

        $pertemuan = Pertemuan::all()->where('id_kelasMapelGuru', $id);
        
        return view('guru.pertemuan')
            ->with('kelas', $kelas)
            ->with('mapel', $mapel)
            ->with('mapel2', $mapel2)
            ->with('pertemuan', $pertemuan)
            ->with('modul', $modul)
            ->with('tugas', $tugas)
            ->with('id', $id)
        ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pertemuan  $pertemuan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pertemuan $pertemuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pertemuan  $pertemuan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pertemuan $pertemuan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pertemuan  $pertemuan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pertemuan $pertemuan)
    {
        //
    }
}
