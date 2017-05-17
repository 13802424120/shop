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
    return view('welcome');
});


Route::get('sort/lst', 'SortController@lst');
Route::any('sort/add', 'SortController@add');
Route::any('sort/edit', 'SortController@edit');
Route::any('sort/delete', 'SortController@delete');


Route::any('goods/add', 'GoodsController@add');
Route::get('goods/lst', 'GoodsController@lst');
Route::get('goods/type', 'GoodsController@type');
Route::get('goods/size', 'GoodsController@size');
Route::get('goods/property', 'GoodsController@property');