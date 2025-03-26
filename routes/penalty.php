<?php

use App\Http\Controllers\PenaltyController;
use Illuminate\Support\Facades\Route;

Route::get('/penalties', [PenaltyController::class, 'index'])->name('penalties.index');
Route::get('/penalties/create', [PenaltyController::class, 'create'])->name('penalties.create');
Route::post('/penalties', [PenaltyController::class, 'store'])->name('penalties.store');
Route::get('/penalties/edit/{id}', [PenaltyController::class, 'edit'])->name('penalties.edit');
Route::post('/penalties/{id}', [PenaltyController::class, 'update'])->name('penalties.update');