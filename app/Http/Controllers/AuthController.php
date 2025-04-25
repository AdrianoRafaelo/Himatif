<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\LocalUser;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        try {
            $response = Http::asForm()->post('https://cis.del.ac.id/api/jwt-api/do-auth', [
                'username' => $username,
                'password' => $password,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['token'])) {
                    $token = $data['token'];
                    $user = $data['user'] ?? [];
                    $username = $user['username'] ?? null;

                    if ($username) {
                        $profileResponse = Http::withToken($token)->get(
                            'https://cis.del.ac.id/api/library-api/mahasiswa?username=' . $username . '&status=Aktif'
                        );

                        if ($profileResponse->successful()) {
                            $mahasiswaList = $profileResponse->json();
                            $mahasiswa = $mahasiswaList['data']['mahasiswa'][0] ?? null;

                            if ($mahasiswa && ($mahasiswa['prodi_name'] ?? null) === 'DIII Teknologi Informasi') {
                                $nama     = $mahasiswa['nama'] ?? $user['username'];
                                $prodi    = $mahasiswa['prodi_name'];
                                $nim      = $mahasiswa['nim'];
                                $angkatan = $mahasiswa['angkatan'];

                                // Buat atau update user lokal
                                $localUser = LocalUser::updateOrCreate(
                                    ['username' => $username],
                                    [
                                        'nama'     => $nama,
                                        'nim'      => $nim,
                                        'angkatan' => $angkatan,
                                        'prodi'    => $prodi,
                                    ]
                                );

                                // Set role hanya saat user baru
                                if ($localUser->wasRecentlyCreated) {
                                    $localUser->role = 'mahasiswa';
                                    $localUser->save();
                                }

                                $role = $localUser->role;

                                // Simpan session
                                session([
                                    'token' => $token,
                                    'user' => array_merge($user, [
                                        'nama'  => $nama,
                                        'prodi' => $prodi,
                                        'role'  => $role
                                    ])
                                ]);

                                return $this->redirectByRole($role);
                            } else {
                                return back()->withErrors(['login' => 'Hanya mahasiswa DIII Teknologi Informasi yang bisa login.']);
                            }
                        }

                        return back()->withErrors(['login' => 'Gagal mengambil data mahasiswa.']);
                    }

                    return back()->withErrors(['login' => 'Username tidak ditemukan.']);
                }
            }

            return back()->withErrors(['login' => 'Login gagal. Username/password salah atau tidak terdaftar.']);
        } catch (\Exception $e) {
            return back()->withErrors(['login' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function logout()
    {
        session()->forget(['user', 'token']);
        return redirect()->route('login');
    }

    protected function redirectByRole($role)
    {
        switch ($role) {
            case 'admin':
                return redirect('/admin')->with('success', 'Login berhasil!');
            case 'kaprodi':
                return redirect('/admin/kaprodi')->with('success', 'Login berhasil!');
            case 'bendahara':
                return redirect('/admin/keuangan')->with('success', 'Login berhasil!');
            case 'mahasiswa':
            default:
                return redirect('/')->with('success', 'Login berhasil!');
        }
    }
}
