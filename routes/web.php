<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return redirect('/login');
});

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    include __DIR__ . '/sys_admin/roles.php';
    include __DIR__ . '/sys_admin/users.php';
    include __DIR__ . '/settings/company_settings.php';
    include __DIR__ . '/settings/myAccount.php';
    include __DIR__ . '/app/app_lookup.php';
});

