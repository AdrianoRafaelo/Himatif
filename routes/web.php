<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\AdminMahasiswaController;
use App\Http\Controllers\WorkprogramController;
use App\Http\Controllers\ProkerController;
use App\Http\Controllers\ProposalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rute untuk halaman home (publik, tanpa autentikasi)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rute autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute yang memerlukan autentikasi
Route::middleware('auth.custom')->group(function () {
    Route::get('/admin', fn() => view('admin.dashboard'));
    Route::get('/admin/keuangan', fn() => view('admin.keuangan'));
    Route::get('/admin/kas/{angkatan?}', [AdminMahasiswaController::class, 'index'])->name('admin.kas.index');
    Route::post('/admin/kas', [AdminMahasiswaController::class, 'store'])->name('admin.kas.store');
    Route::resource('proker', ProkerController::class);
});

// Rute khusus untuk admin
Route::middleware(['auth.admin'])->group(function () {
    Route::get('/admin/role', [AdminRoleController::class, 'index'])->name('admin.role.index');
    Route::post('/admin/role', [AdminRoleController::class, 'storeRole'])->name('admin.role.index');
});


Route::middleware('auth.custom')->prefix('admin')->name('admin.')->group(function () {
    Route::get('proposals', [ProposalController::class, 'index'])->name('proposals.index');
    Route::get('proposals/create', [ProposalController::class, 'create'])->name('proposals.create');
    Route::post('proposals', [ProposalController::class, 'store'])->name('proposals.store');
    // Kaprodi - lihat, setujui, tolak proposal
Route::get('/kaprodi/proposals', [ProposalController::class, 'kaprodiIndex'])->name('kaprodi.proposals.index');
Route::patch('/kaprodi/proposals/{proposal}/approve', [ProposalController::class, 'approve'])->name('kaprodi.proposals.approve');
Route::patch('/kaprodi/proposals/{proposal}/reject', [ProposalController::class, 'reject'])->name('kaprodi.proposals.reject');
});
