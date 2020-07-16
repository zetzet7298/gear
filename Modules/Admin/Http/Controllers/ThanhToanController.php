<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Admin\core\Services\CTHoaDonService;
use Modules\Admin\core\Services\HoaDonService;
use Modules\common\components\mysql\DB_driver;

class ThanhToanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public $service;
    public $cthoadon_service;
    public $db;
    public function __construct(HoaDonService $service, CTHoaDonService $cthoadon_service)
    {
        $this->service = $service;
        $this->cthoadon_service = $cthoadon_service;
        $this->db = new DB_driver();
    }

    public function all(){
        $result = $this->service->getAll();
        return \response()->json($result);
    }

    public function duyetdon($id){
        $data = [
            'TrangThai' => 'Đã xác nhận'
        ];
        $this->db->update('hoadon',$data,'MaHD = '.$id);
        return 'Thành công';
    }

    public function huydon($id){
        $data = [
            'TrangThai' => 'Đã huỷ'
        ];
        $this->db->update('hoadon',$data,'MaHD = '.$id);
        return 'Thành công';
    }

    public function danglayhang($id){
        $data = [
            'TrangThai' => 'Đang lấy hàng'
        ];
        $this->db->update('hoadon',$data,'MaHD = '.$id);
        return 'Thành công';
    }

    public function dalayhang($id){
        $data = [
            'TrangThai' => 'Đã lấy hàng'
        ];
        $this->db->update('hoadon',$data,'MaHD = '.$id);
        return 'Thành công';
    }

    public function danggiaohang($id){
        $data = [
            'TrangThai' => 'Đang giao hàng'
        ];
        $this->db->update('hoadon',$data,'MaHD = '.$id);
        return 'Thành công';
    }

    public function dagiaohang($id){
        $data = [
            'TrangThai' => 'Đã giao hàng'
        ];
        $this->db->update('hoadon',$data,'MaHD = '.$id);
        return 'Thành công';
    }
    public function user($id){
        $result = $this->service->show($id);
        return \response()->json($result);
    }

    public function index()
    {
        return view('admin::hoadon.danhsach');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $result = $this->cthoadon_service->show($id);
        return \response()->json($result);
    }

    public function detail(){
        return View('admin::hoadon.chitiet');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
