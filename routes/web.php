<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HoController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\Data_diriController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [HoController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/logout', [ProfileController::class, 'logout'])->name('auth.logout');

    // Routes for 'Cabang'
    Route::get('/ho/cabang', [HoController::class, 'cabang'])->middleware('role:admin')->name('ho.cabang');
    Route::delete('/cabang/delete/{id}', [HoController::class, 'destroy'])->middleware('role:admin')->name('cabang.destroy');
    Route::post('/cabang/store', [HoController::class, 'store'])->middleware('role:admin')->name('cabang.store');
    Route::get('/cabang/edit/{id}', [HoController::class, 'edit'])->middleware('role:admin')->name('cabang.edit');
    Route::put('/cabang/update/{id}', [HoController::class, 'update'])->middleware('role:admin')->name('cabang.update');

    // Routes for 'Tujuan'
    Route::get('/ho/tujuan', [HoController::class, 'tujuan'])->middleware('role:admin')->name('ho.tujuan');
    Route::post('/ho/tujuan', [HoController::class, 'storeTujuan'])->middleware('role:admin')->name('ho.tujuan.store');
    Route::get('/ho/tujuan/edit/{id}', [HoController::class, 'editTujuan'])->middleware('role:admin')->name('ho.tujuan.edit');
    Route::put('/ho/tujuan/update/{id}', [HoController::class, 'updateTujuan'])->middleware('role:admin')->name('ho.tujuan.update');
    Route::delete('/ho/tujuan/delete/{id}', [HoController::class, 'destroyTujuan'])->middleware('role:admin')->name('ho.tujuan.destroy');

    // Routes for 'Departemen'
    Route::get('/ho/departemen', [HoController::class, 'departemen'])->middleware('role:admin')->name('ho.departemen');
    Route::post('/ho/departemen', [HoController::class, 'storeDepartemen'])->middleware('role:admin')->name('ho.departemen.store');
    Route::get('/ho/departemen/edit/{id}', [HoController::class, 'editDepartemen'])->middleware('role:admin')->name('ho.departemen.edit');
    Route::put('/ho/departemen/update/{id}', [HoController::class, 'updateDepartemen'])->middleware('role:admin')->name('ho.departemen.update');
    Route::delete('/ho/departemen/delete/{id}', [HoController::class, 'destroyDepartemen'])->middleware('role:admin')->name('ho.departemen.destroy');

    //routes for user
    Route::get('/ho/user', [HoController::class, 'user'])->middleware('role:admin')->name('ho.user');


    // Form
    Route::get('/formpst/form', [FormController::class, 'form'])->middleware(['auth', 'role:admin,user'])->name('formpst.form');
    Route::get('/formpst/show', [FormController::class, 'show'])->middleware(['auth', 'role:admin,user'])->name('formpst.show');
    Route::get('/formpst/list', [FormController::class, 'list'])->middleware(['auth', 'role:admin,user'])->name('formpst.list');
    Route::get('/formpst/edit/{id}', [FormController::class, 'edit'])->middleware(['auth', 'role:admin,user'])->name('formpst.edit');
    Route::get('/formpst/{id}', [FormController::class, 'show'])->name('formpst.show');
    Route::post('/formpst/update/{id}', [FormController::class, 'update'])->name('formpst.update');


    Route::delete('/formpst/delete/{id}', [FormController::class, 'destroy'])->middleware('role:admin')->name('formpst.destroy');
    Route::post('/formpst/store', [FormController::class, 'store'])->middleware('role:admin, user')->name('formpst.store');
    Route::get('/formpst/edit/{id}', [FormController::class, 'edit'])->middleware('role:admin, user')->name('formpst.edit');
    Route::put('/formpst/update/{id}', [FormController::class, 'update'])->middleware('role:admin, user')->name('formpst.update');
    
    //pengajuan routes
    Route::post('/pengajuans/store', [PengajuanController::class, 'store'])->middleware('role:admin, user')->name('pengajuans.store');
    
     // Data_diri Routes
     Route::get('/data_diri/biodata', [Data_diriController::class, 'biodata'])->name('data_diri.biodata');

});



require __DIR__.'/auth.php';
