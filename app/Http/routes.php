<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', function () {
    session(["key" => "Hello World!"]);
    return view('welcome');
});

Route::get('/haha', function () {
    echo session("code");
});

Route::any('view', 'ViewController@index');

Route::group(["prefix" => "admin", "namespace" => "Admin"], function () {
    Route::any("login", "LoginController@login");
    Route::get("quit", "LoginController@quit");
    Route::get("code", "LoginController@code");
});


Route::group(["prefix" => "admin", "namespace" => "Admin"], function () {
    Route::get("index", "IndexController@index");
    Route::get("info", "IndexController@info");
    Route::any("pass", "IndexController@pass");
    Route::any("upload", "CommonController@upload");


    Route::post("cate/changeOrder", "CategoryController@changeOrder");
    Route::resource('category','CategoryController');

    Route::resource('article','ArticleController');
    Route::post("links/changeOrder", "LinksController@changeOrder");
    Route::resource('links','LinksController');

    Route::post("navs/changeOrder", "NavsController@changeOrder");
    Route::resource('navs','NavsController');

    Route::post("config/changeOrder", "ConfigController@changeOrder");
    Route::resource('config','ConfigController');
});