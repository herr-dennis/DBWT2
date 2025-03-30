<?php

use Illuminate\Support\Facades\Route;





Route::get('TestData', function () {
    return app()->make('\App\Http\Controllers\DatenbankController')->getTestData();
});
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/isloggedin', [App\Http\Controllers\AuthController::class, 'isloggedin'])->name('haslogin');
