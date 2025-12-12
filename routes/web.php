<?php

use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PresensiController::class, 'index'])->name('presensi.index');
Route::get('/presensi/form', [PresensiController::class, 'form'])->name('presensi.form');
Route::post('/presensi/store', [PresensiController::class, 'store'])->name('presensi.store');
Route::post('/presensi/checkout', [PresensiController::class, 'checkout'])->name('presensi.checkout');