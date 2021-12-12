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


Route::prefix('openfoodfactssearchproducts')->group(function() {
    Route::get('/', 'OpenfoodfactsSearchProductsController@index')->name('openfoodfactssearchproducts::index');
    Route::get('search', 'OpenfoodfactsSearchProductsController@search')->name('openfoodfactssearchproducts::search');
    Route::post('store', 'OpenfoodfactsSearchProductsController@store')->name('openfoodfactssearchproducts::store');
});
