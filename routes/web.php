<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', "ArticleController@index");
Route::get('/404.html', "PageController@page404");

// article
Route::get('/articles', "ArticleController@index");
Route::post('/articles', "ArticleController@index");
Route::get('/article/{id}', "ArticleController@show");
Route::post('/article/{id}', "ArticleController@updateArticle");

// site
Route::get('/sites', "WechatSiteController@index");
Route::get('/site/{id}', "WechatSiteController@show");

// tool

Route::get('editor',"WechatToolsController@editor");