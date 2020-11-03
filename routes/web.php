<?php

use App\Http\Controllers\HomeController;
use Illuminate\Routing\RouteGroup;
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

//Search
Route::get('search', 'SearchController@post')->name('search.posts');
//End search

//Post
Route::prefix('posts')->middleware('auth')->group(function (){
    Route::get('create','PostController@create')->name('posts.create');
    Route::post('store','PostController@store');
    Route::get('{post:slug}/edit','PostController@edit')->name('post.edit');
    Route::patch('{post:slug}/edit','PostController@update');
    Route::delete('{post:slug}/delete','PostController@destroy');
    Route::get('','PostController@index')->name('posts.index')->withoutMiddleware('auth');
    Route::get('{post:slug}','PostController@show')->name('posts.show')->withoutMiddleware('auth');
});
//End Post

//Category
Route::get('categories/{category:slug}','CategoryController@show')->name('categories.show');
//End category

//Tag
Route::get('tags/{tag:slug}','TagController@show')->name('tags.show');
//End tag

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
