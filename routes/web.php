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
    return redirect('/select');
});

Route::get('/selectedModel/{id}', 'HomeController@index');
// Route::get('/', function () {
//     return redirect('/select');
// });

Route::get('/flickr', function() {
    return view('flickr_API_test');
})->middleware('auth');

Route::get('/render_model/{id}', 'RenderedModelController@show')->middleware('auth');

Route::get('/render_model_backup/{id}', 'RenderedModelController@showBackup')->middleware('auth');

Route::get('/storage/{filename}', 'StorageController@sendFile');
//Route::get('/storage/{filename}', 'StorageController@sendFile')->middleware('auth');

Auth::routes();


Route::get('/home', 'AccountController@index')->middleware('auth');
Route::patch('/home', 'AccountController@update');
Route::get('/select', 'HomeController@select');

Route::get('/submitted', function() {
    return view('submitted');
})->middleware('auth');

// HOTFIX
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
