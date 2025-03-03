<?php

use App\Http\Controllers\MaterialController;
use Illuminate\Support\Facades\Route;

Route::get('/material', [MaterialController::class, 'index'])->name('materials.index');
Route::get('/material/create', [MaterialController::class, 'create'])->name('materials.create');
Route::post('/material/create', [MaterialController::class, 'store'])->name('materials.store');
Route::get('/material/{id}/edit', [MaterialController::class, 'edit'])->name('materials.edit');
Route::post('/material/{id}', [MaterialController::class, 'update'])->name('materials.update');
Route::get('/material/show/{id}', [MaterialController::class, 'show'])->name('materials.show');