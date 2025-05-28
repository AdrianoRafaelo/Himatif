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

        // Jika role yang dipilih adalah kaprodi, pastikan hanya satu user yang menjadi kaprodi
        if ($request->role === 'kaprodi') {
            $existingKaprodi = LocalUser::where('role', 'kaprodi')
                ->where('username', '!=', $request->username)
                ->first();
            if ($existingKaprodi) {
                return redirect()->back()->with('error', 'Sudah ada akun lain yang berperan sebagai kaprodi. Hapus/ubah role kaprodi lama terlebih dahulu.');
            }
        }

        $user = LocalUser::firstOrCreate(
            ['username' => $request->username],
            ['nama' => $request->username] 
        );

        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.role.index')->with('success', 'Role berhasil disimpan untuk ' . $user->username);
    }
}
