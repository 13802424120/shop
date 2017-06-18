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

Route::group(['middleware' => 'login'], function () {
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
        //删除商品属性
        Route::post('deleteGoodsAttr', 'GoodsController@deleteGoodsAttr');
        //商品库存量
        Route::any('stock', 'GoodsController@stock');
    });

    Route::group(['prefix' => 'brand'], function () {
        //品牌列表
        Route::get('/', 'BrandController@lst');
        //添加品牌
        Route::any('add', 'BrandController@add');
        //修改品牌
        Route::any('edit', 'BrandController@edit');
        //删除品牌
        Route::any('delete', 'BrandController@delete');
    });

    Route::group(['prefix' => 'type'], function () {
        //类型列表
        Route::get('/', 'TypeController@lst');
        //添加类型
        Route::any('add', 'TypeController@add');
        //修改类型
        Route::any('edit', 'TypeController@edit');
        //删除类型
        Route::any('delete', 'TypeController@delete');
    });

    Route::group(['prefix' => 'attribute'], function () {
        //属性列表
        Route::get('/', 'AttributeController@lst');
        //添加属性
        Route::any('add', 'AttributeController@add');
        //修改属性
        Route::any('edit', 'AttributeController@edit');
        //删除属性
        Route::any('delete', 'AttributeController@delete');
        //获取属性
        Route::get('getAttr', 'AttributeController@getAttr');
    });
});

Route::group(['prefix' => 'login'], function () {
    // 后台登录
    Route::any('/', 'loginController@index');
    // 退出登录
    Route::get('logout', 'loginController@logout');
});
