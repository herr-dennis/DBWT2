<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('TestData', function () {
    return app()->make('\App\Http\Controllers\DatenbankController')->getTestData();
});
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/isloggedin', [App\Http\Controllers\AuthController::class, 'isloggedin'])->name('haslogin');

Route::get("/", function (){
    return view('mainPageView');
});


Route::get('articles', function (Request $request) {
    return app()->make('\App\Http\Controllers\MainController')->getArticles($request);
});
Route::Post('articles', function (Request $request) {
    return app()->make('\App\Http\Controllers\MainController')->insertArticle($request);
});

Route::get('getCategories', function () {
    return app()->make('\App\Http\Controllers\MainController')->getCategories();
});
Route::get('newarticle', function () {
    return app()->make('\App\Http\Controllers\MainController')->getNewArticle();
    });

Route::get('data' , function(){
    return app()->make('\App\Http\Controllers\MainController')->getData();
});


Route::get('3-ajax1-static' , function(){
    return view("Aufgaben/3-ajax1-static");
});

Route::get('3-ajax2-periodic' , function(){
    return view("Aufgaben/3-ajax2-periodic");
});

Route::get('updateJson' , function(){
    return app()->make('\App\Http\Controllers\UpdateJsonController')-> updateJson();
});

Route::get("newsite" , function (){
    return view("newsiteView");
});

Route::get("M4_Vue" , function (){
    return view("Aufgaben.4-vue1-helloworld");
});
