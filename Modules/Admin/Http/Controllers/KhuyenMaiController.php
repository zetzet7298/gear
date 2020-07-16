<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admin\core\Services\LoaiSPService;
use Modules\Admin\core\Services\MysqlService;
use Modules\common\components\mysql\DB_driver;

class KhuyenMaiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    protected $db;
    public function __construct()
    {
        $this->db = new DB_driver();
    }
    public function all(){
        $result = $this->db->get_list('select * from khuyenmai km, sanpham sp where km.MaSP = sp.MaSP and km.deleteFlag =0');
        return \response()->json($result);
    }
    public function index()
    {
        return view('admin::khuyenmai.danhsach');
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
        $result = $this->db->insert('khuyenmai',$request->all());
        print_r($result);
        if($result){
            \response()->json($result);
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('admin::show');
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
    public function update($id,Request $request)
    {
        $result = $this->db->update('khuyenmai',$request->all(),'MaSP = '.$id);
        print_r($result);
        if($result){
            \response()->json($result);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $result = $this->db->update('khuyenmai',['deleteFlag'=>1],'MaSP = '.$id);
    }
}
