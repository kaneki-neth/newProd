<?php

use App\Http\Controllers\sys_admin\RoleController;

Route::get('/sys_admin/role_controller', [RoleController::class, 'index'])->name('roles.index');
Route::get('/sys_admin/role_controller/view', [RoleController::class, 'view'])->name('roles.view');

Route::get('/sys_admin/role_controller/create', [RoleController::class, 'create'])->name('roles.create');
Route::post('/resto/sys_admin/role_controller/store', [RoleController::class, 'store'])->name('roles.store');

Route::get('/sys_admin/role_controller/edit', [RoleController::class, 'edit'])->name('roles.edit');
Route::post('/sys_admin/role_controller/update', [RoleController::class, 'update'])->name('roles.update');

// Route::delete('/sys_admin/role_controller/delete/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
