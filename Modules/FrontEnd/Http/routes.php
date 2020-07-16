<?php

Route::group(['middleware' => 'web', 'namespace' => 'Modules\FrontEnd\Http\Controllers'], function()
{
    Route::get('/', 'FrontEndController@index');
    Route::get('/product/{id}', 'FrontEndController@detail');
    Route::get('/product/view/{id}', 'FrontEndController@detailView');
    Route::get('cart/content', 'CartController@content');
    Route::post('cart/update', 'FrontEndController@updateSoLuong');
    Route::get('cart/total', 'CartController@total');
    Route::get('cart/count', 'CartController@count');
    Route::get('cart/delete/{routeId}', 'CartController@delete');
    Route::get('cart/deleteAll', 'CartController@deleteAll');
    Route::get('cart/add/{MaSP}', 'CartController@add');
    Route::resource('cart', 'CartController');
    Route::get('/register', 'FrontEndController@register');
    Route::get('/client/login', 'FrontEndController@login');
    Route::post('/client/login', 'FrontEndController@postLogin');
    Route::get('/client/logout', 'FrontEndController@logout');
    Route::resource('payment', 'ThanhToanController');

    Route::get('user', 'FrontEndController@getUser');
});
