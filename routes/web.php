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

Route::group(['middleware' => 'login'], function () {
    //首页
    Route::get('/', 'IndexController@index');

    Route::group(['prefix' => 'sort'], function () {
        //分类列表
        Route::get('lst', 'SortController@lst');
        //添加分类
        Route::any('add', 'SortController@add');
        //修改分类
        Route::any('edit', 'SortController@edit');
        //删除分类
        Route::get('del', 'SortController@del');
    });

    Route::group(['prefix' => 'goods'], function () {
        //商品列表
        Route::get('lst', 'GoodsController@lst');
        //添加商品
        Route::any('add', 'GoodsController@add');
        //修改商品
        Route::any('edit', 'GoodsController@edit');
        //删除商品
        Route::any('del', 'GoodsController@del');
        //删除商品属性
        Route::post('delGoodsAttr', 'GoodsController@delGoodsAttr');
        //商品库存量
        Route::any('stock', 'GoodsController@stock');
    });

    Route::group(['prefix' => 'brand'], function () {
        //品牌列表
        Route::get('lst', 'BrandController@lst');
        //添加品牌
        Route::any('add', 'BrandController@add');
        //修改品牌
        Route::any('edit', 'BrandController@edit');
        //删除品牌
        Route::any('del', 'BrandController@del');
    });

    Route::group(['prefix' => 'type'], function () {
        //类型列表
        Route::get('lst', 'TypeController@lst');
        //添加类型
        Route::any('add', 'TypeController@add');
        //修改类型
        Route::any('edit', 'TypeController@edit');
        //删除类型
        Route::any('del', 'TypeController@del');
    });

    Route::group(['prefix' => 'attribute'], function () {
        //属性列表
        Route::get('lst', 'AttributeController@lst');
        //添加属性
        Route::any('add', 'AttributeController@add');
        //修改属性
        Route::any('edit', 'AttributeController@edit');
        //删除属性
        Route::any('del', 'AttributeController@del');
        //获取属性
        Route::get('getAttr', 'AttributeController@getAttr');
    });

    Route::group(['prefix' => 'permission'], function () {
        //权限列表
        Route::get('lst', 'permissionController@lst');
        //添加权限
        Route::any('add', 'permissionController@add');
        //修改权限
        Route::any('edit', 'permissionController@edit');
        //删除权限
        Route::any('del', 'permissionController@del');
    });

    Route::group(['prefix' => 'role'], function () {
        //角色列表
        Route::get('lst', 'roleController@lst');
        //添加角色
        Route::any('add', 'roleController@add');
        //修改角色
        Route::any('edit', 'roleController@edit');
        //删除角色
        Route::any('del', 'roleController@del');
    });

    Route::group(['prefix' => 'admin'], function () {
        //管理员列表
        Route::get('lst', 'adminController@lst');
        //添加管理员
        Route::any('add', 'adminController@add');
        //修改管理员
        Route::any('edit', 'adminController@edit');
        //删除管理员
        Route::any('del', 'adminController@del');
    });
});

Route::group(['prefix' => 'login'], function () {
    // 后台登录
    Route::get('/', 'loginController@index');
    // 验证登录
    Route::post('checkLogin', 'loginController@checkLogin');
    // 退出登录
    Route::get('logout', 'loginController@logout');
});

Route::get('tips', function () {
    return view('tips');
});

Route::get('info', function () {
    return view('welcome');
});



