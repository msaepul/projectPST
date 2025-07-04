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
    Route::middleware('role:admin,user,hrd,bm,nm,pegawai')->group(function () {
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
        
        //routes for user
        Route::get('/ho/user', [HoController::class, 'user'])->name('ho.user');
        Route::get('/ho/user/add', [HoController::class, 'addUser'])->name('ho.user.add');
        Route::post('/ho/user', [HoController::class, 'storeUser'])->name('ho.user.store');
        Route::get('/ho/user/edit/{id}', [HoController::class, 'editUser'])->name('ho.user.edit');
        Route::put('/ho/user/update/{id}', [HoController::class, 'updateUser'])->name('ho.user.update');
        Route::delete('/ho/user/delete/{id}', [HoController::class, 'destroyUser'])->name('ho.user.destroy');
        Route::post('/ho/user/{id}/upload-signature', [HOController::class, 'uploadSignature'])->name('ho.user.uploadSignature');

        //routes for maskapai
        Route::get('/ho/maskapai', [HoController::class, 'maskapai'])->name('ho.maskapai');
        Route::post('/ho/maskapai', [HoController::class, 'store_Maskapai'])->name('ho.maskapai.store');
        Route::delete('/ho/maskapai/delete/{id}', [HoController::class, 'destroy_Maskapai'])->name('ho.maskapai.destroy');

        //routes for transport
        Route::get('/ho/transport', [HoController::class, 'transport'])->name('ho.transport');
        Route::post('/ho/maskapai', [HoController::class, 'store_Maskapai'])->name('ho.maskapai.store');


        
        Route::get('/formpst/show_pegawai/{form_id}', [HoController::class, 'show_pegawai'])->middleware(['auth', 'role:admin,user,hrd,bm,nm,pegawai'])->name('formpst.show_pegawai');

        // User Routes
        Route::get('/ho/user', [HoController::class, 'user'])->name('ho.user');
        Route::get('/formpst/show_pegawai/{form_id}', [HoController::class, 'show_pegawai'])->name('formpst.show_pegawai');
    });

        Route::middleware('role:admin,user,hrd,bm,nm,pegawai')->group(function () {

        Route::get('/hrd/show_hrd', [HrdController::class, 'show_hrd'])->name('hrd.show_hrd');
        Route::get('/hrd/show/{id}', [HrdController::class, 'show_hrd'])->name('hrd.show_hrd');

        Route::get('/hrd/index_hrd', [HrdController::class, 'index_hrd'])->name('hrd.index_hrd');
        Route::get('/hrd/index_hrd_cabang', [HrdController::class, 'index_hrd_cabang'])->name('hrd.index_hrd_cabang');
        Route::get('/hrd/list_nm', [HrdController::class, 'list_nm'])->name('hrd.list_nm');
    });

    // Admin and User Routes
    Route::middleware('role:admin,user,hrd,bm,nm,pegawai')->group(function () {
        // Form Routes
        Route::get('/formpst/form', [FormController::class, 'form'])->name('formpst.form');
        Route::get('/formpst/show', [FormController::class, 'show'])->name('formpst.show');
        Route::get('/formpst/show/{id}', [FormController::class, 'show'])->name('formpst.show');
        Route::get('/form/{id}/export-csv', [FormController::class, 'exportCSV'])->name('form.export.csv');


        Route::get('/formpst/show_nm', [FormController::class, 'show_nm'])->name('formpst.show_nm');
        Route::get('/formpst/show_nm/{id}', [FormController::class, 'show_nm'])->name('formpst.show_nm');

        Route::get('/formpst/index_keluar', [FormController::class, 'index_keluar'])->name('formpst.index_keluar');
        Route::get('/formpst/index_masuk', [FormController::class, 'index_masuk'])->name('formpst.index_masuk');
        Route::get('/formpst/index_surat', [FormController::class, 'index_surat'])->name('formpst.index_surat');

        Route::post('/formpst/store/{role?}', [FormController::class, 'store'])->name('formpst.store');
        Route::get('/formpst/edit', [FormController::class, 'edit'])->name('formpst.edit');
        Route::get('/formpst/edit/{id}', [FormController::class, 'edit'])->name('formpst.edit');
        Route::put('/formpst/update/{id}', [FormController::class, 'update'])->name('formpst.update');
        Route::delete('/formpst/delete/{id}', [FormController::class, 'destroy'])->name('formpst.destroy');

        Route::post('/formpst/{id}/submit', [FormController::class, 'submit'])->name('form.submit');
        Route::post('/formpst/{id}/submit_nm', [FormController::class, 'submit_nm'])->name('form.submit_nm');
        Route::get('/formpst/surat_tugas/{id}', [FormController::class, 'surat_tugas'])->name('formpst.surat_tugas');
        Route::post('/update-status/{itemId}/{status}', [FormController::class, 'updateStatus'])->name('update.status');

        Route::get('/formpst/ticket', [FormController::class, 'ticket'])->name('formpst.ticket');
        Route::get('/formpst/ticket/{id?}', [FormController::class, 'ticket'])->name('formpst.ticket');
        Route::get('/formpst/show_ticket', [FormController::class, 'show_ticket'])->name('formpst.show_ticket');
        Route::get('/formpst/detail_ticket', [FormController::class, 'detail_ticket'])->name('formpst.detail_ticket');
        Route::post('/formpst/ticketing', [FormController::class, 'store_ticket'])->name('store_ticket');
        Route::get('/get-pemohon/{id}', [FormController::class, 'getPemohon'])->name('get.pemohon');
        Route::get('/get-employees/{formId}', [FormController::class, 'getEmployeesByFormId']);
        Route::post('/store-ticket', [FormController::class, 'store_ticket'])->name('store-ticket');
        Route::get('/ticketing/detail/{id}', [FormController::class, 'getTicketDetails'])->name('ticketing.details');
        Route::get('/ticketing/detail/edit/{id}', [FormController::class, 'editTicketDetail'])->name('ticket.detail.edit');
        Route::put('/ticketing/detail/{id}', [FormController::class, 'updateTicketDetail'])->name('ticket.detail.update');


        Route::get('/formpst/form_nm', [FormController::class, 'form_nm'])->name('formpst.form_nm');
        Route::post('/formpst/form_nm/store', [FormController::class, 'store_nm'])->name('formpst.store_nm');

    });

    // Data Diri Routes
    Route::get('/data_diri/biodata', [Data_diriController::class, 'biodata'])->name('data_diri.biodata');

     // Data_diri Routes
     Route::get('/data_diri/biodata', [Data_diriController::class, 'biodata'])->name('data_diri.biodata');
     Route::get('/forms', [FormController::class, 'index']);

});

require __DIR__.'/auth.php';
