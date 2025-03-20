<?php

use App\Http\Controllers\RoomController;

Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
Route::post('/rooms/store', [RoomController::class, 'store'])->name('rooms.store');
