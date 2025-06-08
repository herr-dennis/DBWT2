<?php

use App\Events\ArtikelAngebotEvent;
use App\Events\MaintenanceEvent;
use App\Events\NewMessage;
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

Route::get("M5_1" , function (){
    return view("M5_Aufgaben.5-ws1-connect");
});

Route::get("M5_2" , function (){
    return view("M5_Aufgaben.5-ws2-message");
});
Route::get("M5_3" , function (){
    return view("M5_Aufgaben.5-ws3-selected-message");
});

Route::get("Events" , function (){
    return view("events");
});


/**
 * EVENTS TRIGGER
 */
Route::get('/send-message', function () {
    $time =now();
    broadcast(new NewMessage('Hallo vom Server! '.$time));
    return response()->json('Nachricht gesendet!');
});

Route::post('/send-angebot', function (Request $request) {
    $msg = $request->input('msg') ? : "Fehler in der API";

    broadcast(new ArtikelAngebotEvent($msg));
     return response()->json('Nachricht gesendet!');
});

Route::get('/wartung', function () {
    broadcast(new MaintenanceEvent('In Kürze verbessern wir Abalo für Sie!
Nach einer kurzen Pause sind wir wieder
für Sie da! Versprochen.'));
    return 'Nachricht gesendet!';
});

