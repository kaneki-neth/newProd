<?php

use App\Http\Controllers\sys_admin\UserController;

Route::get('sys_admin/user', [UserController::class, 'index'])->name('users.index');
Route::get('sys_admin/user/create', [UserController::class, 'create'])->name('users.create');
Route::get('sys_admin/user/reset_password/{user_id}', [UserController::class, 'reset_password'])->name('users.reset_password');
Route::post('sys_admin/user/save/save_reset_password', [UserController::class, 'save_reset_password'])->name('users.save_reset_password');
Route::post('/sys_admin/user/store', [UserController::class, 'store'])->name('users.store');
Route::get('/sys_admin/user/edit', [UserController::class, 'edit'])->name('users.edit');
Route::post('sys_admin/user/update', [UserController::class, 'update'])->name('users.update');
Route::get('/sys_admin/user/view/{id}', [UserController::class, 'show'])->name('users.show');
Route::get('/verify/account', [UserController::class, 'verify_to_changePass'])->name('users.verify');
