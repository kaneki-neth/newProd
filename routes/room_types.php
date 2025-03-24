<?php

use App\Http\Controllers\RoomTypeController;

Route::get('/room_types', [RoomTypeController::class, 'index'])->name('room_types.index');
Route::get('/room_types/create', [RoomTypeController::class, 'create'])->name('room_types.create');
Route::post('/room_types/store', [RoomTypeController::class, 'store'])->name('room_types.store');
Route::get('/room_types/edit/{id}', [RoomTypeController::class, 'edit'])->name('room_types.edit');
Route::post('/room_types/update/{id}', [RoomTypeController::class, 'update'])->name('room_types.update');