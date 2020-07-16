<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admin\core\Services\LoaiSPService;
use Modules\Admin\core\Services\MysqlService;
use Modules\common\components\mysql\DB_driver;

class LoaiSPController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    protected $service;
    protected $mysql_service;
    protected $db;
    public function __construct(LoaiSPService $service, MysqlService $mysql_service)
    {
        $this->service = $service;
        $this->mysql_service = $mysql_service;
        $this->db = new DB_driver();
    }

    public function all(){
        return $this->service->getAll();
    }

    public function allMySQL(){
        return $this->db->get_list('select * from loaisanpham');
    }

    public function index()
    {
        return view('admin::loaisanpham.danhsach');
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
