<?php

use App\Http\Controllers\settings\company_settings;
use Illuminate\Support\Facades\Route;

Route::get('settings/company', [company_settings::class, 'index']);
Route::post('settings/company/update', [company_settings::class, 'update'])->name('update');
Route::get('settings/company/bu', [company_settings::class, 'create'])->name('create');
Route::post('settings/company/bu/create', [company_settings::class, 'store_bu'])->name('store_bu');
Route::get('settings/company/bu/details', [company_settings::class, 'bu_details'])->name('bu_details');
Route::post('settings/company/bu/disabled', [company_settings::class, 'disabled_bu'])->name('disabled_bu');
Route::post('settings/company/bu/enabled', [company_settings::class, 'enabled_bu'])->name('enabled_bu');
Route::get('settings/company/bu/edit', [company_settings::class, 'edit_bu'])->name('edit_bu');
Route::post('settings/company/bu/store_update', [company_settings::class, 'store_update'])->name('store_update');
