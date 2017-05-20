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

//首页
Route::get('/', 'IndexController@index');

Route::group(['prefix' => 'sort'], function () {
    //分类列表
    Route::get('/', 'SortController@lst');
    //添加分类
    Route::any('add', 'SortController@add');
    //修改分类
    Route::any('edit', 'SortController@edit');
    //删除分类
    Route::get('delete', 'SortController@delete');
});

Route::group(['prefix' => 'goods'], function () {
    //商品列表
    Route::get('/', 'GoodsController@lst');
    //添加商品
    Route::any('add', 'GoodsController@add');
    //修改商品
    Route::any('edit', 'GoodsController@edit');
    //删除商品
    Route::any('delete', 'GoodsController@delete');
});

Route::group(['prefix' => 'brand'], function () {
    //品牌列表
    Route::get('/', 'brandController@lst');
    //添加品牌
    Route::any('add', 'brandController@add');
    //修改品牌
    Route::any('edit', 'brandController@edit');
    //删除品牌
    Route::any('delete', 'brandController@delete');
});