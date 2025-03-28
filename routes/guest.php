<?php

use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;

Route::get('/guests', [GuestController::class, 'index'])->name('guests.index');
Route::get('/guests/create', [GuestController::class, 'create'])->name('guests.create');
Route::post('/guests/store', [GuestController::class, 'store'])->name('guests.store');
Route::get('/guests/view/{id}', [GuestController::class, 'view'])->name('guests.view');
Route::get('/guests/edit/{id}', [GuestController::class, 'edit'])->name('guests.edit');
Route::post('/guests/update/{id}', [GuestController::class, 'update'])->name('guests.update');