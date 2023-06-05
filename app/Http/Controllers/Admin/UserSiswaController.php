<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\JurusanTingkatKelas;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use App\Models\Tingkat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserSiswaController extends Controller
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

        $siswa = User::join('siswa', 'users.username', '=', 'siswa.username')
            ->where('users.level_user', 2)
            ->get();

        return view('admin.siswa', ['user' => $user])
                ->with('siswa', $siswa);
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:siswa'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        $prefix = '22'; // Prefix with 00
        $uniqueId = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); // Generate a 4-digit unique ID

        $username = $prefix . $uniqueId;

        // Check if the generated username already exists in the Siswa model
        while (Siswa::where('username', $username)->exists()) {
            $uniqueId = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); // Regenerate the unique ID
            $username = $prefix . $uniqueId;
        }

        $image_name = null; // Default value for image_name

        if ($request->file('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $filename = 'siswa-foto-' . $username . '.' . $extension;
            $image_name = $file->storeAs('file/img/siswa', $filename, 'public');
        } else {
            $image_name = 'file/img/default/profile.png';
        }

        $hashedPassword = Hash::make($username);

        User::create([
            'username' => $username,
            'password' => $hashedPassword,
            'level_user' => 2,
        ]);

        Siswa::create([
            'username' => $username,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'foto' => $image_name,
        ]);

        return redirect('admin/input-siswa')->with('success', 'User Berhasil Ditambahkan');
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
        $siswa = Siswa::find($id);
        return view('admin.siswa')
                ->with('siswa', $siswa);
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
        // Validasi inputan
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('siswa')->ignore($id)],
            'password' => ['nullable', 'string', 'min:4'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        // Cari data siswa berdasarkan ID
        $siswa = Siswa::find($id);

        // Update data siswa
        $siswa->name = $validated['name'];
        $siswa->email = $validated['email'];

        // Proses upload dan update foto ke dalam server jika ada
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = 'siswa-foto-' . $siswa->username . '.' . $foto->getClientOriginalExtension();

            if ($siswa->foto !== 'file/img/default/profile.png') {
                Storage::disk('public')->delete($siswa->foto);
            }

            // Simpan foto baru
            $foto->storeAs('file/img/siswa', $fotoName, 'public');
            $siswa->foto = 'file/img/siswa/' . $fotoName;
        }

        $siswa->save();

        // Update password jika diisi
        if ($request->filled('password')) {
            $user = User::where('username', $siswa->username)->first();
            $user->password = Hash::make($request->input('password'));
            $user->save();
        }

        return redirect()->back()->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $siswa = Siswa::find($id);
        $user = User::where('username', $siswa->username)->first();

        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }
    
        $siswa->delete();

        if ($user) {
            $user->delete();
        }
    
        return redirect()->back()->with('success', 'Data siswa, user, dan file foto berhasil dihapus.');
    }

    public function kelasSiswa_index($t, $j)
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

        return view('admin.kelasSiswa', ['jurusanTingkatKelas' => $jurusanTingkatKelas, 'tingkat' => $tingkat, 'jurusan' => $jurusan])
            ->with('user', $user);
    }

    public function kelasSiswa_store(Request $request)
    {
        $request->validate([
            'id_jurusanTingkatKelas' => ['required'],
            'id_siswa' => ['required'],
        ]);

        // Pemeriksaan apakah siswa sudah terdaftar di kelas lain
        $siswaTerdaftar = KelasSiswa::where('id_siswa', $request->input('id_siswa'))->exists();
        if ($siswaTerdaftar) {
            return redirect()->back()->with('error', 'Siswa sudah terdaftar di kelas lain');
        }

        KelasSiswa::create([
            'id_jurusanTingkatKelas' => $request->input('id_jurusanTingkatKelas'),
            'id_siswa' => $request->input('id_siswa'),
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function kelasSiswa_update(Request $request, $id)
    {
        $request->validate([
            'id_jurusanTingkatKelas' => ['required'],
            'id_siswa' => ['required'],
        ]);

        $kelasSiswa = KelasSiswa::findOrFail($id);

        // Pemeriksaan apakah siswa sudah terdaftar di kelas lain selain kelas saat ini
        $siswaTerdaftar = KelasSiswa::where('id_siswa', $request->input('id_siswa'))
                                    ->where('id', '!=', $id)
                                    ->exists();
        if ($siswaTerdaftar) {
            return redirect()->back()->with('error', 'Siswa sudah terdaftar di kelas lain');
        }

        $kelasSiswa->id_jurusanTingkatKelas = $request->input('id_jurusanTingkatKelas');
        $kelasSiswa->id_siswa = $request->input('id_siswa');
        $kelasSiswa->save();

        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }

    public function kelasSiswa_destroy($id)
    {
        $kelasSiswa = KelasSiswa::findOrFail($id);
        $kelasSiswa->delete();

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }
    
}