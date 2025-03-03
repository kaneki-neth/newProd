<?php

use App\Http\Controllers\NewsEventsController;
use Illuminate\Support\Facades\Route;

Route::get('/news_events', [NewsEventsController::class, 'index'])->name('news_events.index');
Route::get('/news_events/create', [NewsEventsController::class, 'create'])->name('news_events.create');
Route::post('/news_events/create', [NewsEventsController::class, 'store'])->name('news_events.store');
