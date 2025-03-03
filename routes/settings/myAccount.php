<?php

use App\Http\Controllers\settings\myAccount;
use Illuminate\Support\Facades\Route;

Route::get('settings/myAccount', [myAccount::class, 'index']);
Route::post('settings/myAccount/user_update', [myAccount::class, 'user_update']);
Route::post('settings/myAccount/user_changepass', [myAccount::class, 'user_changepass'])->name('user.changepass');
Route::post('settings/myAccount/user_changepass/on_login', [myAccount::class, 'user_changepass_onlogin'])->name('user.changepass.on_login');
