<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
Route::post('/companies/store', [CompanyController::class, 'store'])->name('companies.store');
Route::get('/companies/edit/{id}', [CompanyController::class, 'edit'])->name('companies.edit');
Route::post('/companies/update/{id}', [CompanyController::class, 'update'])->name('companies.update');
