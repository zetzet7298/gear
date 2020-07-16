<?php

Route::group(['middleware' => 'web', 'prefix' => 'admin', 'namespace' => 'Modules\Admin\Http\Controllers'], function()
{
    Route::get('/', 'AdminController@index');
    Route::get('product','ProductController@index');
    Route::get('test', function () {
        return UserHelper::getUserName('admin');
    });
    Route::get('loaisp_product/{maLoaiSP}','ProductController@productByLoaiSP');
    Route::get('product/search','ProductController@search');
    Route::get('product/paginate','ProductController@paginate');
    Route::get('product/all','ProductController@all');
    Route::get('daxoa','ProductController@daxoa');
    Route::get('product/deleted','ProductController@allDeleted');
    Route::get('product/detail/{id}','ProductController@get');
    Route::get('product/recovery/{id}','ProductController@khoiphuc');
    Route::resource('product','ProductController');
    Route::get('getData','ProductController@getData');
    Route::get('loaisp/all','LoaiSPController@all');
    Route::get('thuonghieu/all','ThuongHieuController@all');
    Route::post('uploadImage','ProductController@uploadImage');
    Route::get('loaisp/all2','LoaiSPController@allMySQL');
    Route::resource('loaisp','LoaiSPController');
    Route::resource('thuonghieu','ThuongHieuController');
    Route::resource('hoadon','HoaDonController');
    Route::get('thanhtoan/all','ThanhToanController@all');
    Route::get('thanhtoan/user/{id}','ThanhToanController@user');
    Route::get('thanhtoan/detail/{id}','ThanhToanController@detail');
    Route::resource('thanhtoan','ThanhToanController');
    Route::get('thanhtoan/all','ThanhToanController@all');
    Route::get('thanhtoan/duyetdon/{id}','ThanhToanController@duyetdon');
    Route::get('thanhtoan/huydon/{id}','ThanhToanController@huydon');
    Route::get('thanhtoan/danglayhang/{id}','ThanhToanController@danglayhang');
    Route::get('thanhtoan/dalayhang/{id}','ThanhToanController@dalayhang');
    Route::get('thanhtoan/danggiaohang/{id}','ThanhToanController@danggiaohang');
    Route::get('thanhtoan/dagiaohang/{id}','ThanhToanController@dagiaohang');

    Route::get('khuyenmai/all','KhuyenMaiController@all');
    Route::get('khachhang/all','KhachHangController@all');
    Route::get('trahang/all','TraHangController@all');
    Route::get('baocao/all','DoanhThuController@all');
    Route::resource('khuyenmai','KhuyenMaiController');
    Route::resource('khachhang','KhachHangController');
    Route::resource('trahang','TraHangController');
    Route::resource('baocao','DoanhThuController');
});
