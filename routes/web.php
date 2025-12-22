<?php

use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PresensiController::class, 'index'])->name('presensi.index');
Route::get('/presensi/form', [PresensiController::class, 'form'])->name('presensi.form');
Route::post('/presensi/store', [PresensiController::class, 'store'])->name('presensi.store');
Route::post('/presensi/checkout', [PresensiController::class, 'checkout'])->name('presensi.checkout');

// Routes untuk laporan
Route::get('/presensi/export', [ReportController::class, 'export'])->name('presensi.export');
Route::get('/presensi/report', [ReportController::class, 'index'])->name('presensi.report');