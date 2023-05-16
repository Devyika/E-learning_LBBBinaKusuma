<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = User::join('admin', 'users.username', '=', 'admin.username')
            ->where('users.level_user', 0)
            ->get();

        return view('admin.admin')->with('admin', $admin);
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
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|unique:admin,email|max:69|email',
            'password' => ['required', 'string', 'min:4'],
            'level_user' => ['required', 'integer'],
            'foto' => ['required'],
        ]);

        if ($request->file('foto')) {
            $image_name = $request->file('foto')->store('file/img/admin', 'public');
        }

        $hashedPassword = Hash::make($request->input('password'));

        User::create([
            'username' => $request->input('username'),
            'name' => $request->input('name'),
            'password' => $hashedPassword,
            'level_user' => $request->input('level_user'),
        ]);

        Admin::create([
            'username' => $request->input('username'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'foto' => $image_name,
        ]);

        return redirect('admin/admin')->with('success', 'User Berhasil Ditambahkan');
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
        $admin = Admin::find($id);
        $user = User::where('username', $admin->username)->first();

        if ($admin->foto) {
            Storage::disk('public')->delete($admin->foto);
        }
    
        $admin->delete();

        if ($user) {
            $user->delete();
        }
    
        return redirect()->back()->with('success', 'Data admin, user, dan file foto berhasil dihapus.');
    }
    
}
