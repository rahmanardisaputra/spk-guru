<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuruController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\FloatingController;
use App\Http\Controllers\GuruRewardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

Auth::routes();

// Semua route di dalam grup ini wajib login!
Route::middleware(['auth'])->group(function () {
    
    // Halaman Utama setelah login (Dashboard)
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index']);

    // --- ROUTE UNTUK SEMUA ROLE YANG SUDAH LOGIN ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

});

// Hanya Kepala Sekolah yang bisa hapus data
Route::middleware(['auth', 'role:kepala_sekolah'])->group(function () {
    Route::resource('guru', GuruController::class);

    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
     
    Route::get('/kriteria/{kriteria_id}/subkriteria', [SubKriteriaController::class, 'index'])->name('subkriteria.index');
    Route::post('/kriteria/{kriteria_id}/subkriteria', [SubKriteriaController::class, 'store'])->name('subkriteria.store');
    Route::get('/subkriteria/{id}/edit', [SubKriteriaController::class, 'edit'])->name('subkriteria.edit');
    Route::put('/subkriteria/{id}', [SubKriteriaController::class, 'update'])->name('subkriteria.update');
    Route::delete('/subkriteria/{id}', [SubKriteriaController::class, 'destroy'])->name('subkriteria.destroy');


    Route::get('/floating', [FloatingController::class, 'index'])->name('floating.index');
    Route::post('/floating', [FloatingController::class, 'store'])->name('floating.store');
    Route::delete('/floating/{id}', [FloatingController::class, 'destroy'])->name('floating.destroy');

    Route::get('/floating/cetak/{supervisi_id}', [FloatingController::class, 'cetakSuratTugas'])->name('floating.cetak');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset_password');
});

// Kepala Sekolah dan Guru Supervisi bisa input nilai
Route::middleware(['auth', 'role:kepala_sekolah,guru_supervisi'])->group(function () {
    
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::get('/penilaian/{guru_id}', [PenilaianController::class, 'create'])->name('penilaian.create');
    Route::post('/penilaian/{guru_id}', [PenilaianController::class, 'store'])->name('penilaian.store');

    Route::get('/perhitungan', [PerhitunganController::class, 'index'])->name('perhitungan.index');
    Route::get('/perhitungan/detail/{guru_id}', [PerhitunganController::class, 'detail'])->name('perhitungan.detail');
});

// Rute khusus untuk Akun Guru melihat prestasinya & upload arsip
Route::middleware(['role:guru'])->group(function () {
    Route::get('/penghargaan-guru', [GuruRewardController::class, 'halamanGuru'])->name('reward.guru');
    Route::post('/penghargaan-guru/upload/{guru_id}', [GuruRewardController::class, 'uploadSurat'])->name('reward.upload');
});
// Rute Cetak Surat (Bisa diakses Guru untuk cetak, dan Admin/KS untuk melihat)
Route::get('/penghargaan/cetak-pengumuman/{guru_id}', [GuruRewardController::class, 'cetakPengumuman'])->name('reward.cetak_pengumuman');
Route::get('/penghargaan/cetak-insentif/{guru_id}', [GuruRewardController::class, 'cetakInsentif'])->name('reward.cetak_insentif');
// Rute Monitoring untuk Kepala Sekolah / Admin
Route::middleware(['role:kepala_sekolah'])->group(function () {
    Route::get('/monitoring-penghargaan', [GuruRewardController::class, 'halamanAdmin'])->name('reward.admin');
});