<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\JurusanTingkatKelas;
use App\Models\Guru;
use App\Models\Tingkat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class UserGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::join('guru', 'users.username', '=', 'guru.username')
                ->select('users.username', 'guru.*')
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:guru'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'modal_close' => false,
                'message' => 'Data gagal ditambahkan. ' .$validator->errors()->first(),
                'data' => $validator->errors()
            ]);
        }

        $prefix = '11'; // Prefix with 11
        $uniqueId = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); // Generate a 4-digit unique ID

        $username = $prefix . $uniqueId;

        // Check if the generated username already exists in the Guru model
        while (Guru::where('username', $username)->exists()) {
            $uniqueId = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); // Regenerate the unique ID
            $username = $prefix . $uniqueId;
        }

        $image_name = null; // Default value for image_name

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $randomString = Str::random(3);
            $filename = 'guru-foto-' . $username . '-' . $randomString . '.' . $extension;
            $image_name = $file->storeAs('file/img/guru', $filename, 'public');
        } else {
            $image_name = 'file/img/default/profile.png';
        }        

        $hashedPassword = Hash::make($username);

        User::create([
            'username' => $username,
            'password' => $hashedPassword,
            'level_user' => 1,
        ]);

        Guru::create([
            'username' => $username,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'foto' => $image_name,
        ]);

        return response()->json([
            'status' => true,
            'modal_close' => false,
            'message' => 'Data berhasil ditambahkan',
            'data' => null
        ]);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guru = Guru::find($id);

        if ($guru) {
            $user = User::where('username', $guru->username)->first();
            if ($user) {
                $guru->level_user = $user->level_user;
            } else {
                $guru->level_user = null;
            }
            return response()->json($guru);
        } else {
            return response()->json(['error' => 'Data not found'], 404);
        }
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('guru')->ignore($id)],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'modal_close' => false,
                'message' => 'Data gagal diubah. ' .$validator->errors()->first(),
                'data' => $validator->errors()
            ]);
        }

        // Cari data Guru berdasarkan ID
        $guru = Guru::find($id);

        if (!$guru) {
            return response()->json(['error' => 'Guru tidak ditemukan.'], 404);
        }

        // Update data Guru
        $guru->name = $request->input('name');
        $guru->email = $request->input('email');

        // Proses upload dan update foto ke dalam server jika ada
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $extension = $foto->getClientOriginalExtension();
            $randomString = Str::random(3); // Menghasilkan string acak sepanjang 3 karakter
            $fotoName = 'guru-foto-' . $guru->username . '-' . $randomString . '.' . $extension;

            if ($guru->foto !== 'file/img/default/profile.png') {
                Storage::disk('public')->delete($guru->foto);
            }            

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

        return response()->json([
            'status' => true,
            'modal_close' => false,
            'message' => 'Data berhasil diubah',
            'data' => null
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        try {
            $guru = Guru::find($id);
            $user = User::where('username', $guru->username)->first();

            if ($guru->foto && $guru->foto !== 'file/img/default/profile.png') {
                Storage::disk('public')->delete($guru->foto);
            }

            $guru->delete();

            if ($user) {
                $user->delete();
            }

            return response()->json([
                'status' => true,
                'modal_close' => false,
                'message' => 'Data berhasil dihapus',
                'data' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'modal_close' => false,
                'message' => 'Gagal menghapus data',
                'data' => null
            ]);
        }
    }
    
    public function data()
    {
        $data = Guru::selectRaw('id, username, name, email, foto');

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }
    
}