<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HoController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HrdController;
use App\Http\Controllers\Data_diriController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', [HoController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile/edit/{id}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store');
    Route::patch('/profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete/{id}', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/logout', [ProfileController::class, 'logout'])->name('auth.logout');

    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        // Cabang Routes
        Route::get('/ho/cabang', [HoController::class, 'cabang'])->name('ho.cabang');
        Route::post('/cabang/store', [HoController::class, 'store'])->name('cabang.store');
        Route::get('/cabang/edit/{id}', [HoController::class, 'edit'])->name('cabang.edit');
        Route::put('/cabang/update/{id}', [HoController::class, 'update'])->name('cabang.update');
        Route::delete('/cabang/delete/{id}', [HoController::class, 'destroy'])->name('cabang.destroy');

        // Tujuan Routes
        Route::get('/ho/tujuan', [HoController::class, 'tujuan'])->name('ho.tujuan');
        Route::post('/ho/tujuan', [HoController::class, 'storeTujuan'])->name('ho.tujuan.store');
        Route::get('/ho/tujuan/edit/{id}', [HoController::class, 'editTujuan'])->name('ho.tujuan.edit');
        Route::put('/ho/tujuan/update/{id}', [HoController::class, 'updateTujuan'])->name('ho.tujuan.update');
        Route::delete('/ho/tujuan/delete/{id}', [HoController::class, 'destroyTujuan'])->name('ho.tujuan.destroy');

        // Departemen Routes
        Route::get('/ho/departemen', [HoController::class, 'departemen'])->name('ho.departemen');
        Route::post('/ho/departemen', [HoController::class, 'storeDepartemen'])->name('ho.departemen.store');
        Route::get('/ho/departemen/edit/{id}', [HoController::class, 'editDepartemen'])->name('ho.departemen.edit');
        Route::put('/ho/departemen/update/{id}', [HoController::class, 'updateDepartemen'])->name('ho.departemen.update');
        Route::delete('/ho/departemen/delete/{id}', [HoController::class, 'destroyDepartemen'])->name('ho.departemen.destroy');

        // User Routes
        Route::get('/ho/user', [HoController::class, 'user'])->name('ho.user');
        Route::get('/formpst/show_pegawai/{form_id}', [HoController::class, 'show_pegawai'])->name('formpst.show_pegawai');
        Route::get('/hrd/list_hrd', [HrdController::class, 'list_hrd'])->name('hrd.list_hrd');
        Route::get('/hrd/list_bm', [HrdController::class, 'list_bm'])->name('hrd.list_bm');
        Route::get('/hrd/list_nm', [HrdController::class, 'list_nm'])->name('hrd.list_nm');
    });

    // Admin and User Routes
    Route::middleware('role:admin,user')->group(function () {
        // Form Routes
        Route::get('/formpst/form', [FormController::class, 'form'])->name('formpst.form');
        Route::get('/formpst/show', [FormController::class, 'show'])->name('formpst.show');
        Route::get('/formpst/show/{id}', [FormController::class, 'show'])->name('formpst.show');
        Route::get('/formpst/index', [FormController::class, 'index'])->name('formpst.index');
        Route::get('/formpst/list', [FormController::class, 'list'])->name('formpst.list');
        Route::post('/formpst/store', [FormController::class, 'store'])->name('formpst.store');
        Route::get('/formpst/edit/{id}', [FormController::class, 'edit'])->name('formpst.edit');
        Route::put('/formpst/update/{id}', [FormController::class, 'update'])->name('formpst.update');
        Route::delete('/formpst/delete/{id}', [FormController::class, 'destroy'])->name('formpst.destroy');
        Route::post('/form/submit/{formId}', [FormController::class, 'submitForm'])->name('form.submit');
        Route::post('/form/reject/{formId}', [FormController::class, 'rejectForm'])->name('form.reject');

        Route::post('/update-status/{itemId}/{status}', [FormController::class, 'updateStatus'])->name('update.status');
        
    });

    // Data Diri Routes
    Route::get('/data_diri/biodata', [Data_diriController::class, 'biodata'])->name('data_diri.biodata');

    // Form
    Route::get('/formpst/form', [FormController::class, 'form'])->middleware(['auth', 'role:admin,user'])->name('formpst.form');
    Route::get('/formpst/show', [FormController::class, 'show'])->middleware(['auth', 'role:admin,user'])->name('formpst.show');
    Route::get('/formpst/list', [FormController::class, 'list'])->middleware(['auth', 'role:admin,user'])->name('formpst.list');
    Route::post('/formpst/store', [FormController::class, 'store'])->middleware('role:admin, user')->name('formpst.store');
    Route::get('formpst/edit/{id}', [FormController::class, 'edit'])->name('formpst.edit');
    Route::put('/formpst/update/{id}', [FormController::class, 'update'])->middleware('role:admin, user')->name('formpst.update');
    Route::delete('/formpst/delete/{id}', [FormController::class, 'destroy'])->middleware('role:admin')->name('formpst.destroy');
    //pengajuan routes
    Route::post('/pengajuans/store', [PengajuanController::class, 'store'])->middleware('role:admin, user')->name('pengajuans.store');

    Route::delete('/pengajuans/delete/{id}', [FormController::class, 'destroy'])->middleware('role:admin, user')->name('pengajuans.destroy');

    
     // Data_diri Routes
     Route::get('/data_diri/biodata', [Data_diriController::class, 'biodata'])->name('data_diri.biodata');
     Route::get('/forms', [FormController::class, 'index']);

    // Pengajuan Routes
    Route::post('/pengajuans/store', [PengajuanController::class, 'store'])->name('pengajuans.store');
    Route::delete('/pengajuans/delete/{id}', [PengajuanController::class, 'destroy'])->name('pengajuans.destroy');
});

require __DIR__.'/auth.php';
