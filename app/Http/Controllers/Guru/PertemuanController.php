<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
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
        $userId = Auth::user()->id;
    
        $kelas = DB::table('kelas_mapel_guru')
            ->join('kelas', 'kelas_mapel_guru.id_kelas', '=', 'kelas.id')
            ->select('kelas.nama', 'id_kelas')
            ->where('id_guru', $userId)
            ->groupBy('id_kelas')
            ->get();

        foreach($kelas as $k){
            $kls = $k->id_kelas;
        }
        
        $mapel = DB::table('kelas_mapel_guru')
            ->join('mapel', 'kelas_mapel_guru.id_mapel', '=', 'mapel.id')
            ->select('mapel.nama','kelas_mapel_guru.id')
            ->where('id_guru', $userId)
            ->where('id_kelas', $kls)
            ->get();

        return view('guru.pertemuan')
            ->with('kelas', $kelas)
            ->with('mapel', $mapel)
        ;
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pertemuan  $pertemuan
     * @return \Illuminate\Http\Response
     */
    public function show(Pertemuan $pertemuan)
    {
        //
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
