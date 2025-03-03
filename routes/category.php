<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/category', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/category/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/category/create', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::post('/category/{id}', [CategoryController::class, 'update'])->name('categories.update');

// Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
// Route::get('/category/{id}', [CategoryController::class, 'show'])->name('categories.show');
