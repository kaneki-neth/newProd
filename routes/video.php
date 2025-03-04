<?php

use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
Route::get('/videos/create', [VideoController::class, 'create'])->name('videos.create');
Route::post('/videos/store', [VideoController::class, 'store'])->name('videos.store');
Route::get('/videos/edit/{id}', [VideoController::class, 'edit'])->name('videos.edit');
Route::post('/videos/update/{id}', [VideoController::class, 'update'])->name('videos.update');
Route::get('/videos/show/{id}', [VideoController::class, 'show'])->name('videos.show');
Route::get('/get-thumbnail', [VideoController::class, 'getThumbnail'])->name('videos.getThumbnail');