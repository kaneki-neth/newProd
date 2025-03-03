<?php

use App\Http\Controllers\app\app_lookup;
use Illuminate\Support\Facades\Route;

Route::get('app/app_lookup', [app_lookup::class, 'index'])->name('app_lookup.index');
Route::get('app/app_lookup/create', [app_lookup::class, 'create']);
Route::get('app/app_lookup/update', [app_lookup::class, 'update']);
Route::get('app/app_lookup/view', [app_lookup::class, 'view']);
Route::post('app/app_lookup/store', [app_lookup::class, 'store']);
Route::post('app/app_lookup/disabled', [app_lookup::class, 'disabled_lookup']);
Route::post('app/app_lookup/enabled', [app_lookup::class, 'enabled_lookup']);
Route::post('app/app_lookup/store_update', [app_lookup::class, 'store_update']);
