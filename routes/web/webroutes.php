<?php

use App\Http\Controllers\web\home;
use App\Http\Controllers\web\aboutus;
use App\Http\Controllers\web\archive;
use App\Http\Controllers\web\contactus;
use App\Http\Controllers\web\newsevent;
use Illuminate\Support\Facades\Route;

Route::get('/', [home::class, 'index']);

Route::get('/about', [aboutus::class, 'index']);

Route::get('/digital_archive', [archive::class, 'index']);
Route::get('/digital_archive_content', [archive::class, 'archive_details']);

Route::get('/events', [newsevent::class, 'index']);
Route::get('/events_news_content', [newsevent::class, 'events_news_content']);
Route::get('/events_research_content', [newsevent::class, 'events_research_content']);
Route::get('/events_blog_content', [newsevent::class, 'events_blog_content']);
Route::get('/events_events_content', [newsevent::class, 'events_events_content']);

Route::get('/contact', [contactus::class, 'index']);


