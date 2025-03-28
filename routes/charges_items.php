<?php

use App\Http\Controllers\ChargesItemsController;
use Illuminate\Support\Facades\Route;

Route::get('/charges-items', [ChargesItemsController::class, 'index'])->name('charges_items.index');
Route::get('/charges-items/create', [ChargesItemsController::class, 'create'])->name('charges_items.create');
Route::post('/charges-items', [ChargesItemsController::class, 'store'])->name('charges_items.store');
Route::get('/charges-items/edit/{id}', [ChargesItemsController::class, 'edit'])->name('charges_items.edit');
Route::post('/charges-items/{id}', [ChargesItemsController::class, 'update'])->name('charges_items.update');