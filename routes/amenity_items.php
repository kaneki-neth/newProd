<?php

use App\Http\Controllers\AmenityItemController;
use Illuminate\Support\Facades\Route;

Route::get('/amenity-items', [AmenityItemController::class, 'index'])->name('amenity_items.index');
Route::get('/amenity-items/create', [AmenityItemController::class, 'create'])->name('amenity_items.create');
Route::post('/amenity-items', [AmenityItemController::class, 'store'])->name('amenity_items.store');
Route::get('/amenity-items/edit/{id}', [AmenityItemController::class, 'edit'])->name('amenity_items.edit');
Route::post('/amenity-items/update/{id}', [AmenityItemController::class, 'update'])->name('amenity_items.update');
