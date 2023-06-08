<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\JurusanTingkatKelas;
use App\Models\Kelas;
use App\Models\KelasMapel;
use App\Models\Tingkat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminKelasController extends Controller
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
        
        $kelas = Kelas::all();

        return view('admin.kelas', ['kelas' => $kelas])
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
            'nama' => ['required', 'string', 'max:50'],
        ]);

        Kelas::create([
            'nama' => $request->input('nama'),
        ]);

        return redirect('admin/input-kelas')->with('success', 'User Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelas $kelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:50'],
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->nama = $request->input('nama');
        $kelas->save();

        return redirect('admin/input-kelas')->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);

        // Delete related records in the "jurusan_tingkat_kelas" table
        $kelas->jurusanTingkatKelas()->delete();

        $kelas->delete();

        return redirect('admin/input-kelas')->with('success', 'Kelas berhasil dihapus.');
    }

    public function jurusanTingkatKelas_index($t, $j)
    {
        $user = User::join('admin', 'users.username', '=', 'admin.username')
                ->select('users.username', 'admin.*')
                ->where('users.id', Auth::user()->id)
                ->first();
        
        $jurusanTingkatKelas = JurusanTingkatKelas::with('jurusan', 'tingkat', 'kelas')
            ->where('id_tingkat', $t)
            ->where('id_jurusan', $j)
            ->get();

        $tingkat = Tingkat::find($t);
        $jurusan = Jurusan::find($j);

        return view('admin.jurusanTingkatKelas', ['jurusanTingkatKelas' => $jurusanTingkatKelas, 'tingkat' => $tingkat, 'jurusan' => $jurusan])
            ->with('user', $user);
    }

    public function jurusanTingkatKelas_store(Request $request)
    {
        $request->validate([
            'id_jurusan' => ['required'],
            'id_tingkat' => ['required'],
            'id_kelas' => ['required'],
        ]);
    
        $existingEntry = JurusanTingkatKelas::where('id_jurusan', $request->input('id_jurusan'))
            ->where('id_tingkat', $request->input('id_tingkat'))
            ->where('id_kelas', $request->input('id_kelas'))
            ->exists();
    
        if ($existingEntry) {
            return redirect()->back()->with('error', 'Kombinasi id_jurusan, id_tingkat, dan id_kelas sudah ada');
        }
    
        JurusanTingkatKelas::create([
            'id_jurusan' => $request->input('id_jurusan'),
            'id_tingkat' => $request->input('id_tingkat'),
            'id_kelas' => $request->input('id_kelas'),
        ]);
    
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }
    
    public function jurusanTingkatKelas_update(Request $request, $id)
    {
        $request->validate([
            'id_jurusan' => ['required'],
            'id_tingkat' => ['required'],
            'id_kelas' => ['required'],
        ]);
    
        $jurusanTingkatKelas = JurusanTingkatKelas::findOrFail($id);
    
        $existingEntry = JurusanTingkatKelas::where('id_jurusan', $request->input('id_jurusan'))
            ->where('id_tingkat', $request->input('id_tingkat'))
            ->where('id_kelas', $request->input('id_kelas'))
            ->where('id', '!=', $id)
            ->exists();
    
        if ($existingEntry) {
            return redirect()->back()->with('error', 'Kombinasi id_jurusan, id_tingkat, dan id_kelas sudah ada');
        }
    
        $jurusanTingkatKelas->id_jurusan = $request->input('id_jurusan');
        $jurusanTingkatKelas->id_tingkat = $request->input('id_tingkat');
        $jurusanTingkatKelas->id_kelas = $request->input('id_kelas');
        $jurusanTingkatKelas->save();
    
        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }

    public function jurusanTingkatKelas_destroy($id)
    {
        $jurusanTingkatKelas = JurusanTingkatKelas::findOrFail($id);
        $jurusanTingkatKelas->delete();

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }
}
