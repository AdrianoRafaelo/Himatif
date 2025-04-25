<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LocalUser;

class AdminRoleController extends Controller
{
    
    public function index()
    {
        $users = LocalUser::whereIn('role', ['admin', 'bendahara', 'kaprodi'])->get();
        return view('admin.role.index', compact('users'));
    }

    
    public function storeRole(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'role' => 'required|string|in:admin,kaprodi,bendahara,mahasiswa',
        ]);

        $user = LocalUser::firstOrCreate(
            ['username' => $request->username],
            ['nama' => $request->username] 
        );

        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.role.index')->with('success', 'Role berhasil disimpan untuk ' . $user->username);
    }
}
