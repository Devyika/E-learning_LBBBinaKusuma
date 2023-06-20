<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isEmpty;

class UserAdminController extends Controller
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

        $admin = User::join('admin', 'users.username', '=', 'admin.username')
            ->where('users.level_user', 0)
            ->get();

        return view('admin.admin', ['user' => $user])
                ->with('admin', $admin);
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admin'],
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

        $prefix = '00'; // Prefix with 00
        $uniqueId = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); // Generate a 4-digit unique ID

        $username = $prefix . $uniqueId;

        // Check if the generated username already exists in the Admin model
        while (Admin::where('username', $username)->exists()) {
            $uniqueId = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); // Regenerate the unique ID
            $username = $prefix . $uniqueId;
        }

        $image_name = null; // Default value for image_name

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $randomString = Str::random(3);
            $filename = 'admin-foto-' . $username . '-' . $randomString . '.' . $extension;
            $image_name = $file->storeAs('file/img/admin', $filename, 'public');
        } else {
            $image_name = 'file/img/default/profile.png';
        }        

        $hashedPassword = Hash::make($username);

        User::create([
            'username' => $username,
            'password' => $hashedPassword,
            'level_user' => 0,
            'hapus' => 0,
        ]);

        Admin::create([
            'username' => $username,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'foto' => $image_name,
            'hapus' => 0,
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
        $admin = Admin::find($id);

        if ($admin) {
            $user = User::where('username', $admin->username)->first();
            if ($user) {
                $admin->level_user = $user->level_user;
            } else {
                $admin->level_user = null;
            }
            return response()->json($admin);
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
        $admin = Admin::find($id);
        $adminId = $admin->id;
        $userId = User::where('username', $admin->username)->pluck('id')->first();
        // Validasi inputan
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($userId), Rule::unique('admin')->ignore($adminId), 'regex:/^[^\s\W]+$/'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admin')->ignore($id)],
            'foto' => ['nullable', 'image', 'max:2048'],
            'password' => [],
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'modal_close' => false,
                'message' => 'Data gagal diubah. ' .$validator->errors()->first(),
                'data' => $validator->errors()
            ]);
        }

        // Cari data Admin berdasarkan ID
        $user = User::where('username', $admin->username)->first();

        if (!$admin) {
            return response()->json(['error' => 'Admin tidak ditemukan.'], 404);
        }

        // Update data Admin
        $admin->username = $request->input('username');
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');

        $user->username = $request->input('username');
        if(empty($request->input('password'))){
    
        }else{
            $user->password = Hash::make($request->input('password'));   
        }

        // Proses upload dan update foto ke dalam server jika ada
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $extension = $foto->getClientOriginalExtension();
            $randomString = Str::random(3); // Menghasilkan string acak sepanjang 3 karakter
            $fotoName = 'admin-foto-' . $admin->username . '-' . $randomString . '.' . $extension;
        
            if ($admin->foto !== 'file/img/default/profile.png') {
                Storage::disk('public')->delete($admin->foto);
            }
        
            // Simpan foto baru
            $foto->storeAs('file/img/admin', $fotoName, 'public');
            $admin->foto = 'file/img/admin/' . $fotoName;
        }        

        $admin->save();
        $user->save();

        // Update password jika diisi
        if ($request->filled('password')) {
            $user = User::where('username', $admin->username)->first();
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
        $admin = Admin::find($id);
        $user = User::where('username', $admin->username)->first();

        $admin->hapus = 1;
        $user->hapus = 1;

        $admin->save();
        $user->save();

        return response()->json([
            'status' => true,
            'modal_close' => false,
            'message' => 'Data berhasil dihapus',
            'data' => null
        ]);
    }
    
    public function data()
    {
        $data = Admin::selectRaw('id, username, name, email, foto')->where('hapus', 0);

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }
}
