<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
     public function index()
     {
         $user = User::join('admin', 'users.username', '=', 'admin.username')
                 ->select('users.username', 'admin.*')
                 ->where('users.id', Auth::user()->id)
                 ->first();
         
         $jurusan = Jurusan::all();
         $kelas = Kelas::all();
 
         return view('admin.mapel', ['kelas' => $kelas, 'jurusan' => $jurusan])
                 ->with('user', $user);
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
        $userId = Auth::user()->id;

        $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:mapel'],
            'jurusan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string']
        ]);

        Mapel::create([
            'nama' => $request->input('nama'),
            'jurusan' => $request->input('jurusan'),
            'deskripsi' => $request->input('deskripsi'),
            'user_id' => $userId
        ]);

        return redirect('mata-pelajaran')->with('success', 'User Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mapel  $mapel
     * @return \Illuminate\Http\Response
     */
    public function show(Mapel $mapel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mapel  $mapel
     * @return \Illuminate\Http\Response
     */
    public function edit(Mapel $mapel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mapel  $mapel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mapel $mapel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mapel  $mapel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mapel $mapel)
    {
        //
    }
}
