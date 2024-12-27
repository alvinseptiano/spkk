<?php

use App\Http\Controllers\listkaryawanController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\NilaiKaryawanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KaryawanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Butuh akses admin atau manager
Route::middleware(['role:admin,manager'])->group(function () {
    Route::post('/addgrade', [KaryawanController::class, 'addGrade'])->name('employees.addgrade');
    Route::get('/listkaryawan', [karyawanController::class, 'index'])->name('listkaryawan.index');
    Route::get('/listkaryawan/create', [karyawanController::class, 'create'])->name('listkaryawan.create');
    Route::post('/listkaryawan/store', [karyawanController::class, 'store'])->name('listkaryawan.store');
    Route::get('/listkaryawan/{id}/edit', [karyawanController::class, 'edit'])->name('listkaryawan.edit');
    Route::put('/listkaryawan/{id}/update', [karyawanController::class, 'update'])->name('listkaryawan.update');
    Route::delete('/listkaryawan/{id}/destroy', [karyawanController::class, 'destroy'])->name('listkaryawan.destroy');
    Route::get('/addgrade/{id}', [KaryawanController::class, 'showAddGradeForm'])->name('employees.showAddGradeForm');
    Route::patch('/nilaikaryawan/{id}/{column}/update', [KaryawanController::class, 'updateGrade'])->name('nilaikaryawan.update');
    Route::get('/listkaryawansearch', [KaryawanController::class, 'search'])->name('listkaryawansearch');
    Route::get('/nilaikaryawansearch', [KaryawanController::class, 'search'])->name('nilaikaryawansearch');
    Route::get('/nilaikaryawan', [KaryawanController::class, 'index'])->name('nilaikaryawan.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/hasilakhir', [HasilController::class, 'index'])->name('hasil.index');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/logout', [ProfileController::class, 'logout'])->name('logout');
});

require __DIR__.'/auth.php';
