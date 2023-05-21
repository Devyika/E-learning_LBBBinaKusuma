<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Modul;
use App\Models\Pertemuan;
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
            'id_guru_mapel_kelas' => $id
        ]);

        return redirect('guru/pertemuan/'.$id)->with('success', 'User Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pertemuan  $pertemuan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userId = Auth::user()->id;
    
        $kelas = DB::table('kelas_mapel_guru')
            ->join('kelas', 'kelas_mapel_guru.id_kelas', '=', 'kelas.id')
            ->select('kelas.nama', 'id_kelas')
            ->where('id_guru', $userId)
            ->groupBy('id_kelas')
            ->orderBy('nama')
            ->get();


        foreach($kelas as $k){
            $kls = $k->id_kelas;
        }
        
        $mapel = DB::table('kelas_mapel_guru as a')
            ->join('mapel as b', 'a.id_mapel', '=', 'b.id')
            ->select('b.nama as nama','a.id_kelas as kelas', 'a.id_mapel as id_mapel', 'a.id as id')
            ->where('id_guru', $userId)
            ->get();

        $mapel2 = DB::table('kelas_mapel_guru as a')
        ->join('mapel as b', 'a.id_mapel', '=', 'b.id')
        ->join('kelas as c', 'c.id', '=', 'a.id_kelas')
        ->select('b.nama','a.id', 'c.nama as kelas')
        ->where('a.id', $id)
        ->get();

        $modul = DB::table('pertemuan')
        ->join('modul', 'modul.id_pertemuan', '=', 'pertemuan.id')
        ->select('modul.nama as nama', 'modul.id_pertemuan as id_pertemuan')
        ->where('pertemuan.id_guru_mapel_kelas', $id)
        ->get();

        $tugas = DB::table('pertemuan')
        ->join('tugas', 'tugas.id_pertemuan', '=', 'pertemuan.id')
        ->select('tugas.nama as nama', 'tugas.id_pertemuan as id_pertemuan')
        ->where('pertemuan.id_guru_mapel_kelas', $id)
        ->get();

        $pertemuan = Pertemuan::all()->where('id_guru_mapel_kelas', $id);
        
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
