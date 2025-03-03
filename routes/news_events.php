<?php

use App\Http\Controllers\NewsEventsController;
use Illuminate\Support\Facades\Route;

Route::get('/news_events', [NewsEventsController::class, 'index'])->name('news_events.index');
