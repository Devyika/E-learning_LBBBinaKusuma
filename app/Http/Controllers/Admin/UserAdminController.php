<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admin'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        $prefix = '00'; // Prefix with 00
        $uniqueId = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); // Generate a 4-digit unique ID

        $username = $prefix . $uniqueId;

        // Check if the generated username already exists in the Admin model
        while (Admin::where('username', $username)->exists()) {
            $uniqueId = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); // Regenerate the unique ID
            $username = $prefix . $uniqueId;
        }

        $image_name = null; // Default value for image_name

        if ($request->file('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $filename = 'admin-foto-' . $username . '.' . $extension;
            $image_name = $file->storeAs('file/img/admin', $filename, 'public');
        } else {
            $image_name = 'file/img/default/profile.png';
        }

        $hashedPassword = Hash::make($username);

        User::create([
            'username' => $username,
            'password' => $hashedPassword,
            'level_user' => 0,
        ]);

        Admin::create([
            'username' => $username,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'foto' => $image_name,
        ]);

        return redirect('admin/input-admin')->with('success', 'User Berhasil Ditambahkan');
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

        // Cari data admin berdasarkan ID
        $admin = Admin::find($id);

        // Update data admin
        $admin->name = $validated['name'];
        $admin->email = $validated['email'];

        // Proses upload dan update foto ke dalam server jika ada
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = 'admin-foto-' . $admin->username . '.' . $foto->getClientOriginalExtension();

            if ($admin->foto !== 'file/img/default/profile.png') {
                Storage::disk('public')->delete($admin->foto);
            }

            // Simpan foto baru
            $foto->storeAs('file/img/admin', $fotoName, 'public');
            $admin->foto = 'file/img/admin/' . $fotoName;
        }

        $admin->save();

        // Update password jika diisi
        if ($request->filled('password')) {
            $user = User::where('username', $admin->username)->first();
            $user->password = Hash::make($request->input('password'));
            $user->save();
        }

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
         $admin = Admin::find($id);
         $user = User::where('username', $admin->username)->first();
     
         if ($admin->foto && $admin->foto !== 'file/img/default/profile.png') {
             Storage::disk('public')->delete($admin->foto);
         }
     
         $admin->delete();
     
         if ($user) {
             $user->delete();
         }
     
         return redirect()->back()->with('success', 'Data admin, user, dan file foto berhasil dihapus.');
     }     
    
}
