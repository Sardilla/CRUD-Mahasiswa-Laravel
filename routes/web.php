<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

// ✅ Export & Cetak
Route::get('/mahasiswa/cetak-pdf', [MahasiswaController::class, 'cetakPdf'])
    ->name('mahasiswa.cetakPdf');

Route::get('/mahasiswa/export-excel', [MahasiswaController::class, 'exportExcel'])
    ->name('mahasiswa.exportExcel');

// ✅ CRUD + Pencarian
Route::resource('mahasiswa', MahasiswaController::class);
