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


Route::get('/', function () {
    return view('welcome_visitor');
});
// Route::get('/', function () {
//     return redirect('/select');
// });

Route::get('/flickr', function() {
    return view('flickr_API_test');
});

Route::get('/render_model/{id}', 'RenderedModelController@show');

Route::get('/render_model_backup/{id}', 'RenderedModelController@showBackup');

Route::get('/storage/{filename}', 'StorageController@sendFile');

Auth::routes();


Route::get('/home', 'AccountController@index');
Route::patch('/home', 'AccountController@update');
Route::get('/select', 'HomeController@select');

Route::get('/submitted', function() {
    return view('submitted');
});

// HOTFIX
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
