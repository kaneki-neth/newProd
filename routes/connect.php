<?php

// admin side
use App\Http\Controllers\ConnectController;
use Illuminate\Support\Facades\Route;

Route::get('/connect-mail', [ConnectController::class, 'index']);
Route::get('/read_email', [ConnectController::class, 'read_email']);