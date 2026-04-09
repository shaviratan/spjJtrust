<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\NewsAnnouncementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProkerController;
use App\Http\Controllers\OrganizationController;
use App\Models\News;
use App\Models\Activities;
use App\Models\Compro;

Route::get('/', function () {
    $news = News::where('status', 'published')
                ->orderBy('created_date', 'desc')
                ->take(3) // Ambil 6 berita saja untuk halaman depan
                ->get();
    $kegiatan = Activities::orderBy('created_at', 'desc')->get();
    $compro = Compro::all();
    return view('frontend.index', compact('news', 'kegiatan', 'compro'));
})->name('home');

Route::get('/berita', [NewsAnnouncementController::class, 'indexFront'])->name('news.index');

Route::get('/news/{slug}', [FrontendController::class, 'show'])->name('news.show');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/register', [AuthController::class, 'registerNewMember'])->name('register');
Route::post('/dologin', [AuthController::class, 'checkLogin'])->name('do.login');
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot.password');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkViaWA'])->name('forgot.password.post');
// Form untuk input password baru
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
// Proses update password
Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPassword'])->name('password.update');

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login');
})->name('logout');
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); 
    })->name('dashboard');
    Route::get('admin.anggota.tambah', [AnggotaController::class, 'tambahAnggotaIndex'])->name('admin.anggota.tambah');
    Route::post('admin/anggota/tambah', [AnggotaController::class, 'storeAnggota'])->name('anggota.store');
    Route::get('admin.anggota.data', [AnggotaController::class, 'dataAnggotaIndex'])->name('admin.anggota.data');
    Route::get('admin/anggota/{id}/edit', [AnggotaController::class, 'editAnggota'])->name('admin.anggota.edit');
    Route::delete('/admin/anggota/delete/{id}', [AnggotaController::class, 'deleteAnggota'])->name('admin.anggota.delete');
    Route::get('/admin/anggota/show/{id}', [AnggotaController::class, 'showData'])->name('admin.anggota.show');
    Route::post('/admin/anggota/update/{id}', [AnggotaController::class, 'updateData'])->name('admin.anggota.update');
    Route::post('/admin/anggota/import', [AnggotaController::class, 'importAnggota'])->name('admin.anggota.import');
    Route::get('/admin/anggota/export', [AnggotaController::class, 'exportAnggota'])->name('admin.anggota.export');
    Route::get('/admin/anggota/download-template', [AnggotaController::class, 'downloadTemplate'])->name('admin.anggota.template');
    Route::get('admin.pengumuman', [NewsAnnouncementController::class, 'createAnnoun'])->name('admin.pengumuman');
    Route::post('admin.pengumuman.store', [NewsAnnouncementController::class, 'storeAnnoun'])->name('admin.pengumuman.store');
    Route::get('admin.pengumuman.data', [NewsAnnouncementController::class, 'dataAllAnnoun'])->name('admin.pengumuman.data');
    Route::post('admin/announcements/update/{id}', [NewsAnnouncementController::class, 'updateAnnoun'])->name('admin.pengumuman.update');
    Route::delete('/admin/announcements/delete/{id}', [NewsAnnouncementController::class, 'deleteAnnoun'])->name('admin.announcements.delete');
    Route::get('/admin/announcements/databy/{id}', [NewsAnnouncementController::class, 'getDataAnnouById'])->name('admin.announcements.byId');
    Route::post('admin.news.store', [NewsAnnouncementController::class, 'storeNews'])->name('admin.news.store');
    Route::get('admin.berita', [NewsAnnouncementController::class, 'createNews'])->name('admin.berita');
    Route::get('admin.berita.data', [NewsAnnouncementController::class, 'dataAllNews'])->name('admin.berita.data');
     Route::get('/admin/news/databy/{id}', [NewsAnnouncementController::class, 'getDataNewsById'])->name('admin.news.byId');
     Route::post('admin/news/update/{id}', [NewsAnnouncementController::class, 'updateNews'])->name('admin.news.update');
    Route::get('admin.user', [UserController::class, 'create'])->name('admin.user');
    Route::post('admin.users.store', [UserController::class, 'store'])->name('admin.users.store');
    Route::post('admin/users/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('admin/users/delete/{id}', [UserController::class, 'delete'])->name('admin.users.delete');
    Route::post('admin/users/reset-password/{id}', [UserController::class, 'resetPassword'])->name('admin.users.reset');
    Route::get('admin.user.role', [RoleController::class, 'index'])->name('admin.user.role');
    Route::post('admin/role/store', [RoleController::class, 'store'])->name('admin.role.store');
    Route::post('admin/role/update/{id}', [RoleController::class, 'update'])->name('admin.role.update');
    Route::delete('admin/role/delete/{id}', [RoleController::class, 'delete'])->name('admin.role.delete');
    Route::get('admin.pengaturan.profil', [CompanyProfileController::class, 'index'])->name('admin.pengaturan.profil');
    Route::post('admin.profile.update', [CompanyProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('admin.pengaturan.kontak', [CompanyProfileController::class, 'indexContact'])->name('admin.pengaturan.kontak');
    Route::post('admin.identity.update', [CompanyProfileController::class, 'updateContact'])->name('admin.identity.update');
    Route::get('admin.pengaduan', [AspirasiController::class, 'dataAllAspirasi'])->name('admin.pengaduan');
    Route::get('admin.aspirasi.show', [AspirasiController::class, 'dataAllAspirasi'])->name('admin.aspirasi.show');
    Route::post('admin.aspirasi.updateStatus', [AspirasiController::class, 'updateStatus'])->name('admin.aspirasi.updateStatus');
    Route::get('admin.aspirasi.klasifikasi', [AspirasiController::class, 'klasifikasi'])->name('admin.aspirasi.klasifikasi');
    Route::get('admin/aspirasi/filter', [AspirasiController::class, 'dataAspirasiByKategori'])->name('admin.aspirasi.dataAllByCategory');
    Route::get('admin.pengaduan.export', [AspirasiController::class, 'exportAspirasi'])->name('admin.pengaduan.export');
    Route::get('/excel', [AspirasiController::class, 'exportExcel'])->name('admin.laporan.excel');
    Route::get('admin.laporan.pdf', [AspirasiController::class, 'exportPdf'])->name('admin.laporan.pdf');
    Route::get('/admin/aspirasi/filter', [AspirasiController::class, 'filtering'])->name('admin.aspirasi.filtering');
    Route::get('admin.kegiatan.dokumentasi', [ProkerController::class, 'galeryIndex'])->name('admin.kegiatan.dokumentasi');
    Route::post('gallery.store', [ProkerController::class, 'storeGallery'])->name('gallery.store');
    Route::get('admin.kegiatan', [ProkerController::class, 'kegiatanIndex'])->name('admin.kegiatan');
    Route::post('kegiatan.store', [ProkerController::class, 'storeKegiatan'])->name('kegiatan.store');
    Route::get('admin.structur.organization', [OrganizationController::class, 'create'])->name('admin.structur.organization');
    // Member
    Route::get('/member/beranda', function () {
        return view('member.home');
    })->name('homeLogin');
    Route::get('member.aspirasi.index', [AspirasiController::class, 'create'])->name('member.aspirasi.index');
    Route::post('member.aspirasi.store', [AspirasiController::class, 'store'])->name('member.aspirasi.store');
    Route::get('member.aspirasi.data', [AspirasiController::class, 'dataAspirasi'])->name('member.aspirasi.data');
    Route::get('/member/aspirasi/detail/{id}', [AspirasiController::class, 'getDataDetailbyId'])->name('admin.anggota.show');
    Route::get('account.setting', [AuthController::class, 'accountSettingShow'])->name('account.setting');
    Route::post('change.photo', [AuthController::class, 'changePhoto'])->name('change.photo');
    Route::post('update.Profile', [AuthController::class, 'updateProfile'])->name('update.Profile');
});


