<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ResearchController;
use Illuminate\Support\Facades\Route;

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
Route::post('/news/create', [NewsController::class, 'store'])->name('news.store');
Route::get('/news/{n_id}/edit', [NewsController::class, 'edit'])->name('news.edit');
Route::post('/news/{n_id}/edit', [NewsController::class, 'update'])->name('news.update');
Route::get('/news/{n_id}', [NewsController::class, 'show'])->name('news.show');

Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
Route::post('/blogs/create', [BlogController::class, 'store'])->name('blogs.store');
Route::get('/blogs/{b_id}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
Route::post('/blogs/{b_id}/edit', [BlogController::class, 'update'])->name('blogs.update');
Route::get('/blogs/{b_id}', [BlogController::class, 'show'])->name('blogs.show');

Route::get('/research', [ResearchController::class, 'index'])->name('research.index');
Route::get('/research/create', [ResearchController::class, 'create'])->name('research.create');
Route::post('/research/create', [ResearchController::class, 'store'])->name('research.store');
Route::get('/research/{r_id}/edit', [ResearchController::class, 'edit'])->name('research.edit');
Route::post('/research/{r_id}/edit', [ResearchController::class, 'update'])->name('research.update');
Route::get('/research/{r_id}', [ResearchController::class, 'show'])->name('research.show');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
Route::post('/events/create', [EventController::class, 'store'])->name('events.store');
Route::get('/events/{ne_id}/edit', [EventController::class, 'edit'])->name('events.edit');
Route::post('/events/{ne_id}/edit', [EventController::class, 'update'])->name('events.update');
Route::get('/events/{ne_id}', [EventController::class, 'show'])->name('events.show');
