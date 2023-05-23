<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\kelas_mapel_guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        DB::statement("SET SQL_MODE=''");
        $user = User::join('guru', 'users.username', '=', 'guru.username')
                ->select('users.username', 'guru.*')
                ->where('users.id', Auth::user()->id)
                ->first();

        $id_guru = Auth::user()->username;

        $userId = Guru::all()->where('username', $id_guru)->pluck('id');
    
        $kelas = DB::table('kelas_mapel_guru as a')
            ->join('jurusan_tingkat_kelas as b', 'a.id_jurusanTingkatKelas', '=', 'b.id')
            ->join('kelas as c', 'b.id_kelas', '=', 'c.id')
            ->join('jurusan as d', 'b.id_jurusan', '=', 'd.id')
            ->join('tingkat as e', 'b.id_tingkat', '=', 'e.id')
            ->select('c.nama as kelas','d.name as jurusan','e.name as tingkat', 'b.id as id_kelas')
            ->where('id_guru', $userId)
            ->groupBy('a.id_jurusanTingkatKelas')
            ->orderBy('nama')
            ->get();

        //dd($kelas);
        
        $mapel = DB::table('kelas_mapel_guru as a')
            ->join('mapel as b', 'a.id_mapel', '=', 'b.id')
            ->select('b.nama as nama','a.id_jurusanTingkatKelas as kelas', 'a.id_mapel as id_mapel', 'a.id as id')
            ->where('id_guru', $userId)
            ->get();

        return view('guru.dashboard')
            ->with('kelas', $kelas)
            ->with('mapel', $mapel)
            ->with('user', $user)
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
