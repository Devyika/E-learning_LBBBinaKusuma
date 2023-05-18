<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JurusanController extends Controller
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

        return view('admin.jurusan', ['jurusan' => $jurusan])
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
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'deskripsi' => ['nullable', 'string', 'max:255'],
        ]);

        Jurusan::create([
            'name' => $request->input('name'),
            'deskripsi' => $request->input('deskripsi'),
        ]);

        return redirect('admin/sekolah-jurusan')->with('success', 'User Berhasil Ditambahkan');
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
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'deskripsi' => ['nullable', 'string', 'max:255'],
        ]);

        $jurusan = Jurusan::findOrFail($id);
        $jurusan->name = $request->input('name');
        $jurusan->deskripsi = $request->input('deskripsi');
        $jurusan->save();

        return redirect('admin/sekolah-jurusan')->with('success', 'Data Jurusan Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return redirect('admin/sekolah-jurusan')->with('success', 'Data Jurusan Berhasil Dihapus');
    }
}
