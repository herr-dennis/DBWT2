<?php

use Illuminate\Support\Facades\Route;



Route::get('TestData', function () {
    return app()->make('\App\Http\Controllers\DatenbankController')->getTestData();
});
