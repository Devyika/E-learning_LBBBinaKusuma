<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserGuruController extends Controller
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

        $guru = User::join('guru', 'users.username', '=', 'guru.username')
            ->where('users.level_user', 1)
            ->get();

        return view('admin.guru', ['user' => $user])
                ->with('guru', $guru);
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:guru'],
            'foto' => ['required', 'image', 'max:2148'],
        ]);

        $prefix = '11'; // Prefix with 11
        $uniqueId = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); // Generate a 4-digit unique ID

        $username = $prefix . $uniqueId;

        // Check if the generated username already exists in the guru model
        while (Guru::where('username', $username)->exists()) {
            $uniqueId = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); // Regenerate the unique ID
            $username = $prefix . $uniqueId;
        }

        if ($request->file('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $filename = 'guru-foto-' . $username . '.' . $extension;
            $image_name = $file->storeAs('file/img/guru', $filename, 'public');
        }        

        $hashedPassword = Hash::make($username);

        User::create([
            'username' => $username,
            'password' => $hashedPassword,
            'level_user' => 1,
        ]);

        guru::create([
            'username' => $username,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'foto' => $image_name,
        ]);

        return redirect('admin/input-guru')->with('success', 'User Berhasil Ditambahkan');
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
        $guru = Guru::find($id);
        return view('admin.guru')
                ->with('guru', $guru);
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
        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('guru')->ignore($id)],
        'password' => ['nullable', 'string', 'min:4'],
        'foto' => ['nullable', 'image', 'max:2148'],
    ]);

    // Cari data guru berdasarkan ID
    $guru = Guru::find($id);

    // Update data guru
    $guru->name = $validated['name'];
    $guru->email = $validated['email'];

    // Proses upload dan update foto ke dalam server jika ada
    if ($request->hasFile('foto')) {
        $foto = $request->file('foto');
        $fotoName = 'guru-foto-' . $guru->username . '.' . $foto->getClientOriginalExtension();
        Storage::disk('public')->delete($guru->foto);
        // Simpan foto baru
        $foto->storeAs('file/img/guru', $fotoName, 'public');
        $guru->foto = 'file/img/guru/' . $fotoName;
    }

    $guru->save();

    // Update password jika diisi
    if ($request->filled('password')) {
        $user = User::where('username', $guru->username)->first();
        $user->password = Hash::make($request->input('password'));
        $user->save();
    }

    return redirect()->back()->with('success', 'Data guru berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $guru = Guru::find($id);
        $user = User::where('username', $guru->username)->first();

        if ($guru->foto) {
            Storage::disk('public')->delete($guru->foto);
        }
    
        $guru->delete();

        if ($user) {
            $user->delete();
        }
    
        return redirect()->back()->with('success', 'Data guru, user, dan file foto berhasil dihapus.');
    }
    
}