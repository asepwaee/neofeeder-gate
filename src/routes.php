<?php

use Aseplab\Neofeeder\App\Http\Controllers\NeoMahasiswaController;
use Aseplab\Neofeeder\App\Http\Controllers\NeoDosenController;

Route::group(['prefix' => 'statistik'], function(){
    Route::get('/mahasiswa', [NeoMahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::get('/dosen', [NeoDosenController::class, 'index'])->name('dosen.index');
});