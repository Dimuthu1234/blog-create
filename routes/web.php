<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/post/search', 'PostController@search')->name('post.search');
Route::post('/post/get-all-post', 'PostController@getAllPost')->name('post.getAllPost');
Route::post('/post/get-post-by-id', 'PostController@getPostByID')->name('post.getPostByID');

Route::resource('/post', 'PostController', resourceNames('post'));
Route::resource('/comment', 'CommentController', resourceNames('comment'));
