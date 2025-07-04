<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\AdminMahasiswaController;
use App\Http\Controllers\ProkerController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\studentController;
use App\Http\Controllers\AdminBphController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\StudentRegistrationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CampusApiMahasiswaController;


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
    Route::get('/admin/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard'); 
    Route::get('/admin/keuangan', fn() => view('admin.keuangan'));
    Route::get('/admin/kas/{angkatan?}', [AdminMahasiswaController::class, 'index'])->name('admin.kas.index');
    Route::post('/admin/kas', [AdminMahasiswaController::class, 'store'])->name('admin.kas.store');
    Route::resource('proker', ProkerController::class);

    Route::get('/admin/keuangan', [KeuanganController::class, 'index'])->name('admin.keuangan.index');
    Route::get('/admin/keuangan/create', [KeuanganController::class, 'create'])->name('admin.keuangan.create');
    Route::post('/admin/keuangan', [KeuanganController::class, 'store'])->name('admin.keuangan.store');
    Route::get('/admin/keuangan/{id}/edit', [KeuanganController::class, 'edit'])->name('admin.keuangan.edit');
    Route::put('/admin/keuangan/{id}', [KeuanganController::class, 'update'])->name('admin.keuangan.update');
    Route::delete('/admin/keuangan/{id}', [KeuanganController::class, 'destroy'])->name('admin.keuangan.destroy');
    Route::get('/admin/keuangan/download', [KeuanganController::class, 'downloadExcel'])->name('admin.keuangan.download');
    
    Route::get('/events/{eventId}/register', [StudentRegistrationController::class, 'create'])->name('student.register.create');
    Route::post('/student/register', [StudentRegistrationController::class, 'store'])->name('student.register.store');



});

// Rute khusus untuk admin
Route::middleware(['auth.admin'])->group(function () {
    Route::get('/admin/role', [AdminRoleController::class, 'index'])->name('admin.role.index');
    Route::post('/admin/role', [AdminRoleController::class, 'storeRole'])->name('admin.role.index');
    Route::get('/admin/bph', [AdminBphController::class, 'index'])->name('admin.bph.index');
    Route::post('/admin/bph', [AdminBphController::class, 'store'])->name('admin.bph.store');
    Route::delete('/admin/bph/{id}', [AdminBphController::class, 'destroy'])->name('admin.bph.destroy');

    Route::get('/admin/news', [NewsController::class, 'index'])->name('admin.news.index'); 
    Route::get('admin/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('admin/news', [NewsController::class, 'store'])->name('news.store');
    Route::resource('news', NewsController::class);

    Route::get('/admin/tentang', [TentangController::class, 'index'])->name('admin.tentang.index');
    Route::post('/admin/tentang', [TentangController::class, 'store'])->name('admin.tentang.store');
    Route::put('/admin/tentang/{tentang}', [TentangController::class, 'update'])->name('admin.tentang.update');
    Route::get('admin/tentang/create', [TentangController::class, 'create'])->name('admin.tentang.create');
    Route::post('/tentang', [TentangController::class, 'store'])->name('tentang.store');
    Route::get('/admin/tentang/{id}', [TentangController::class, 'show'])->name('admin.tentang.show');
    Route::get('/tentang/{id}/edit', [TentangController::class, 'edit'])->name('admin.tentang.edit');
    Route::put('/tentang/{id}', [TentangController::class, 'update'])->name('tentang.update');
    Route::delete('/tentang/{id}', [TentangController::class, 'destroy'])->name('tentang.destroy');
    Route::resource('tentang', TentangController::class);

    Route::get('/admin/galeri', [GaleriController::class, 'index'])->name('admin.galeri.index');
    Route::get('/create', [GaleriController::class, 'create'])->name('admin.galeri.create');
    Route::post('/store', [GaleriController::class, 'store'])->name('galeri.store');
    Route::get('/edit/{id}', [GaleriController::class, 'edit'])->name('admin.galeri.edit');
    Route::put('/update/{id}', [GaleriController::class, 'update'])->name('galeri.update');
    Route::delete('/tentang/{id}', [GaleriController::class, 'destroy'])->name('admin.galeri.destroy');

    Route::get('/admin/event', [EventController::class, 'index'])->name('admin.event.index');
    Route::get('admin//event/create', [EventController::class, 'create'])->name('admin.event.create');
    Route::post('admin/event', [EventController::class, 'store'])->name('admin.event.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('admin.event.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('admin.event.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('admin.event.destroy');





});


Route::middleware('auth.custom')->prefix('admin')->name('admin.')->group(function () {
    Route::get('proposals', [ProposalController::class, 'index'])->name('proposals.index');
    Route::get('proposals/create', [ProposalController::class, 'create'])->name('proposals.create');
    Route::post('proposals', [ProposalController::class, 'store'])->name('proposals.store');
    // Kaprodi - lihat, setujui, tolak proposal
    Route::get('/kaprodi/proposals', [ProposalController::class, 'kaprodiIndex'])->name('kaprodi.proposals.index');
    Route::patch('/kaprodi/proposals/{proposal}/approve', [ProposalController::class, 'approve'])->name('kaprodi.proposals.approve');
    Route::patch('/kaprodi/proposals/{proposal}/reject', [ProposalController::class, 'reject'])->name('kaprodi.proposals.reject');

    Route::get('/kaprodi/proker/reports', [ProkerController::class, 'reports'])->name('kaprodi.proker.reports');
    Route::post('/proker/{id}/approve', [ProkerController::class, 'approve'])->name('kaprodi.proker.approve');
    Route::post('/proker/{id}/reject', [ProkerController::class, 'reject'])->name('kaprodi.proker.reject');

});

Route::middleware('auth.custom')->group(function () {
    Route::get('/student', [studentController::class, 'index'])->name('student');
});



Route::get('/organization', [PublicController::class, 'organization'])->name('organization');
Route::get('/news', [NewsController::class, 'news'])->name('news');
Route::get('/tentang', [TentangController::class, 'visi'])->name('tentang');
Route::get('/keuangan', [App\Http\Controllers\KeuanganController::class, 'userIndex'])->name('keuangan');
Route::get('/galeri', [GaleriController::class, 'galeri'])->name('galeri');



Route::get('/events', [EventController::class, 'indexUser'])->name('events');
Route::get('/events/{event}', [EventController::class, 'showUser'])->name('events.show');

// Route untuk pendaftaran event

// Route untuk admin melihat registrasi
Route::get('/registrations', [StudentRegistrationController::class, 'index'])->name('registrations.index')->middleware('auth.admin');
Route::get('/registrations/event/{eventId}', [StudentRegistrationController::class, 'showParticipants'])->name('registrations.showParticipants')->middleware('auth.admin');
Route::patch('/registrations/update-attendance/{id}', [StudentRegistrationController::class, 'updateAttendance'])->name('registrations.updateAttendance')->middleware('auth.admin');

// Jika ada route berikut, HAPUS agar tidak menimpa controller:
// Route::get('/events', function () { return view('events'); })->name('events');
Route::get('/register/{eventId}', [StudentRegistrationController::class, 'create'])->name('student.register.create');
Route::post('/register/{eventId}', [StudentRegistrationController::class, 'store'])->name('event.register.store');
Route::get('/registrations', [StudentRegistrationController::class, 'index'])->name('registrations.index');
Route::get('/registrations/event/{eventId}', [StudentRegistrationController::class, 'showParticipants'])->name('registrations.showParticipants');
Route::patch('/registrations/{id}/attendance', [StudentRegistrationController::class, 'updateAttendance'])->name('registrations.updateAttendance');

// Tambahkan route untuk ekspor
Route::get('/registrations/export/{eventId?}', [StudentRegistrationController::class, 'export'])->name('registrations.export');

// Admin melihat data registrasi (akses dibatasi)
Route::middleware('auth.admin')->prefix('admin')->group(function () {
    Route::get('/partisipan', [StudentRegistrationController::class, 'index'])->name('admin.partisipan.index');
    Route::get('/partisipan/event/{eventId}', [StudentRegistrationController::class, 'showParticipants'])->name('admin.partisipan.show');
    Route::patch('/partisipan/update-attendance/{id}', [StudentRegistrationController::class, 'updateAttendance'])->name('admin.partisipan.updateAttendance');
    Route::post('/partisipan/update-attendance-bulk', [StudentRegistrationController::class, 'updateAttendanceBulk'])->name('admin.partisipan.updateAttendanceBulk');
    Route::get('/partisipan/export/{eventId?}', [StudentRegistrationController::class, 'export'])->name('admin.partisipan.export');
});
Route::get('/admin/event/{event}/participants', [EventController::class, 'showParticipants'])->name('admin.event.participants');

Route::middleware('auth.admin')->prefix('admin')->group(function () {
    Route::get('/campus-students', [CampusApiMahasiswaController::class, 'listStudents'])->name('admin.campus-students.index');
    Route::post('/campus-students/fetch-and-save', [CampusApiMahasiswaController::class, 'fetchAndSaveAllStudents'])->name('admin.campus-students.fetch-and-save');
});
?>








