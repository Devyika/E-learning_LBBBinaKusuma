<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        DB::statement("SET SQL_MODE=''");
        $username_siswa = Auth::user()->username;

        $userId = Siswa::all()->where('username', $username_siswa)->pluck('id');

        $user = User::join('siswa', 'users.username', '=', 'siswa.username')
            ->select('users.username', 'siswa.*')
            ->where('users.id', Auth::user()->id)
            ->first();

        $mapelSiswa = KelasSiswa::with('siswa')
            ->where('id_siswa', $user)
            ->get();

        $pertemuanSidebar = DB::table('pertemuan as a')
        ->join('kelas_mapel_guru as b', 'b.id', '=', 'a.id_kelasMapelGuru')
        ->join('kelas_siswa as c', 'c.id_jurusanTingkatKelas', '=', 'b.id_jurusanTingkatKelas')
        ->select('a.id', 'a.nama', 'a.id_kelasMapelGuru', 'b.id_jurusanTingkatKelas', 'b.id_mapel', 'c.id_siswa')
        ->where('id_siswa', $userId)
        ->orderBy('nama')
        ->get();

        $pertemuan = DB::table('pertemuan as a')
        ->join('kelas_mapel_guru as b', 'b.id', '=', 'a.id_kelasMapelGuru')
        ->join('kelas_siswa as c', 'c.id_jurusanTingkatKelas', '=', 'b.id_jurusanTingkatKelas')
        ->select('a.id', 'a.nama', 'a.id_kelasMapelGuru', 'b.id_jurusanTingkatKelas', 'b.id_mapel', 'c.id_siswa')
        ->where('id_siswa', $userId)
        ->orderBy('nama')
        ->get();

        return view('siswa.dashboard', ['user' => $user, 'mapelSiswa' => $mapelSiswa])
            ->with('pertemuan', $pertemuan)
            ->with('pertemuanSidebar', $pertemuanSidebar);
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
