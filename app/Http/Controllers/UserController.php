<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $admin = Admin::find($id);
        return view('admin.admin')
                ->with('admin', $admin);
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
        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admin')->ignore($id)],
        'password' => ['nullable', 'string', 'min:4'],
        'foto' => ['nullable', 'image', 'max:2048'],
    ]);

    $userLevels = [
        0 => Admin::find($id),
        1 => Guru::find($id),
        2 => Siswa::find($id),
    ];

    $level = $userLevels[Auth::user()->level_user] ?? 'unknown';

    // Update data admin
    $level->name = $validated['name'];
    $level->email = $validated['email'];

    // Proses upload dan update foto ke dalam server jika ada
    if ($request->hasFile('foto')) {
        $foto = $request->file('foto');
        $fotoName = 'admin-foto-' . $level->username . '.' . $foto->getClientOriginalExtension();
        Storage::disk('public')->delete($level->foto);

        // Simpan foto baru
        $foto->storeAs('file/img/admin', $fotoName, 'public');
        $level->foto = 'file/img/admin/' . $fotoName;
    }

    $level->save();

    // Update password jika diisi
    if ($request->filled('password')) {
        $user = User::where('username', $level->username)->first();
        $user->password = Hash::make($request->input('password'));
        $user->save();
    }

    // return dd($request->all())
    return redirect()->back()->with('success', 'Data admin berhasil diperbarui.');
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
