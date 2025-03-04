<?php

use App\Http\Controllers\web\home;
use App\Http\Controllers\web\aboutus;
use App\Http\Controllers\web\archive;
use App\Http\Controllers\web\contactus;
use App\Http\Controllers\web\newsevent;
use Illuminate\Support\Facades\Route;

Route::get('/', [home::class, 'index']);
Route::get('/archive', [archive::class, 'index']);
Route::get('/archive_details', [archive::class, 'archive_details']);
Route::get('/newsevents', [newsevent::class, 'index']);
Route::get('/aboutus', [aboutus::class, 'index']);

