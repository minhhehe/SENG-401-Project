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
    return view('welcome_to_CADA');
});

Route::get('/car_example', function() {
    return view('car_example');
});

<<<<<<< HEAD
Route::get('/render_model/{filename}', 'RenderModelController@show'); // TODO Replace 'filename' with 'id'

// Route::resource('/render_model', 'RenderModelController', [
//     'only' => ['show']
// ]);
=======
Route::get('/render_model/{id}', 'RenderedModelController@show');
>>>>>>> devel

Route::get('/storage/{filename}', 'StorageController@sendFile');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
