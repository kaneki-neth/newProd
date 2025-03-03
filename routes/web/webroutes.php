<?php

use App\Http\Controllers\web\home;
use Illuminate\Support\Facades\Route;

Route::get('/', [home::class, 'index']);


