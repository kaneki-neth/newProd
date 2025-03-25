<?php

use App\Http\Controllers\RoomController;

Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
Route::post('/rooms/store', [RoomController::class, 'store'])->name('rooms.store');
Route::get('/rooms/edit/{id}', [RoomController::class, 'edit'])->name('rooms.edit');
Route::post('/rooms/update/{id}', [RoomController::class, 'update'])->name('rooms.update');
