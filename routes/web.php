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

//分类列表
Route::get('sort/lst', 'SortController@lst');
//添加分类
Route::any('sort/add', 'SortController@add');
//修改分类
Route::any('sort/edit', 'SortController@edit');
//删除分类
Route::any('sort/delete', 'SortController@delete');

//商品列表
Route::get('goods/lst', 'GoodsController@lst');
//添加商品
Route::any('goods/add', 'GoodsController@add');
//修改商品
Route::any('goods/edit', 'GoodsController@edit');
//删除商品
Route::any('goods/delete', 'GoodsController@delete');