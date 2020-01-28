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
    return view('index');
});

Route::get('/about', function () {
    return view('about');
});
Route::get('/bloghome', function () {
    return view('blog-home');
});
Route::get('/blogsingle', function () {
    return view('blog-single');
});
Route::get('/kontak', function () {
    return view('contact');
});

Route::get('/elemen', function () {
    return view('elements');
});

Route::get('/galeri', function () {
    return view('gallery');
});

Route::get('/menu', function () {
    return view('menu');
});

// Route::get('/kontak', function () {
//     return view('contact');
// });

Route::get('/index', function () {
    return view('layouts.index');
});
Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => '/admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index');

    Route::get('/kategori', 'KategoriController@index');
    Route::post('/kategori-store', 'KategoriController@store');
    Route::get('/kategori/{id}/edit', 'KategoriController@edit');
    Route::delete('/kategori-destroy/{id}', 'KategoriController@destroy');

    Route::get('/stokmasuk', 'StokmasukController@index');
    Route::post('/stokmasuk-store', 'StokmasukController@store');
    Route::get('/stokmasuk/{id}/edit', 'StokmasukController@edit');
    Route::delete('/stokmasuk-destroy/{id}', 'StokmasukController@destroy');

    Route::get('/gallery', 'GalleryController@index');
    Route::post('/gallery-store', 'GalleryController@store');
    Route::get('/gallery/{id}/edit', 'GalleryController@edit');
    Route::delete('/gallery-destroy/{id}', 'GalleryController@destroy');
});
