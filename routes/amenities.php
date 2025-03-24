<?php

use App\Http\Controllers\AmenityController;
use Illuminate\Support\Facades\Route;

Route::get('/amenities', [AmenityController::class, 'index'])->name('amenities.index');
Route::get('/amenities/create', [AmenityController::class, 'create'])->name('amenities.create');
Route::post('/amenities', [AmenityController::class, 'store'])->name('amenities.store');
Route::get('/amenities/edit/{id}', [AmenityController::class, 'edit'])->name('amenities.edit');
Route::post('/amenities/update/{id}', [AmenityController::class, 'update'])->name('amenities.update');
