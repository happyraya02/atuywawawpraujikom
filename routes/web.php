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
    return view('frontend.index');
});
Route::get('/shop', function () {
    return view('frontend.shop');
});
Route::get('/checkout', function () {
    return view('frontend.checkout');
});
Route::get('/produk/{gallery}', function () {
    return view('frontend.product');
});
Route::get('/shop/{kategori}', function () {
    return view('frontend.shop');
});



Route::get('/cart', 'Ecommerce\CartController@cart');
Route::get('/getsubtotal', 'Ecommerce\CartController@subtotal');
Route::get('/totalproduk', 'Ecommerce\CartController@totalproduk');

Route::post('/formcart', 'Ecommerce\CartController@addToCart');
Route::post('/formcart-update', 'Ecommerce\CartController@updateCart');


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


Auth::routes();
