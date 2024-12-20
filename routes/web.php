<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HoController;
use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/logout', [ProfileController::class, 'logout'])->name('auth.logout');

    // ho
    Route::get('/ho/cabang', [HoController::class, 'cabang'])->name('ho.cabang');
    Route::get('/ho/tujuan', [HoController::class, 'tujuan'])->name('ho.tujuan');
    Route::get('/ho/departemen', [HoController::class, 'departemen'])->name('ho.departemen');
    Route::delete('/cabang/delete/{id}', [HoController::class, 'destroy'])->name('cabang.destroy');
    Route::post('/cabang/store', [HoController::class, 'store'])->name('cabang.store');
    Route::get('/cabang/edit/{id}', [HoController::class, 'edit'])->name('cabang.edit');
    Route::put('/cabang/update/{id}', [HoController::class, 'update'])->name('cabang.update');

    // form
    Route::get('/formpst/form', [formController::class, 'form'])->name('formpst.form');
    Route::delete('/formpst/delete/{id}', [FormController::class, 'destroy'])->name('formpst.destroy');
    Route::post('/formpst/store', [FormController::class, 'store'])->name('formpst.store');
    Route::get('/formpst/edit/{id}', [FormController::class, 'edit'])->name('formpst.edit');
    Route::put('/formpst/update/{id}', [FormController::class, 'update'])->name('formpst.update');
    Route::get('/formpst/batch/{batchId}', [FormController::class, 'showBatch'])->name('formpst.batch');

});

require __DIR__.'/auth.php';
