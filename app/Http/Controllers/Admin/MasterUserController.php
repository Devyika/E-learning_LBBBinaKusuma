<?php

namespace App\Http\Controllers;

use App\Models\MasterUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MasterUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countAdmin = User::where('level_user', 0)->count();
        $countGuru = User::where('level_user', 1)->count();
        $countSiswa = User::where('level_user', 2)->count();
        return view('guru.masterUser')
                ->with('countAdmin', $countAdmin)
                ->with('countGuru', $countGuru)
                ->with('countSiswa', $countSiswa);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'level_user' => ['required', 'int'],
            'password' => ['required', 'string', 'min:4'],
        ]);

        $hashedPassword = Hash::make($request->input('password'));

        User::create([
            'username' => $request->input('username'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'level_user' => $request->input('level_user'),
            'password' => $hashedPassword,
        ]);

        return redirect('master-user')->with('success', 'User Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterUser  $masterUser
     * @return \Illuminate\Http\Response
     */
    public function show(MasterUser $masterUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterUser  $masterUser
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterUser $masterUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterUser  $masterUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterUser $masterUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterUser  $masterUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterUser $masterUser)
    {
        //
    }
}
