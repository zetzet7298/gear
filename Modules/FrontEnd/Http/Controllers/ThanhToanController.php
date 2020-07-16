<?php

namespace Modules\FrontEnd\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\core\Services\CTHoaDonService;
use Modules\Admin\core\Services\HoaDonService;
use Modules\Admin\core\Services\ThanhToanService;
use Cart;
class ThanhToanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    protected $hoadon_service;
    protected $thanhtoan_service;
    protected $cthoadon_service;
    public function __construct(HoaDonService $hoadon_service, CTHoaDonService $cthoadon_service, ThanhToanService $thanhtoan_service)
    {
        $this->hoadon_service = $hoadon_service;
        $this->cthoadon_service = $cthoadon_service;
        $this->thanhtoan_service = $thanhtoan_service;
    }

    public function index()
    {
        return view('frontend::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('frontend::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */

    public function store(Request $request)
    {
        $data = $request->all();
        $listProducts = $data[0];
        $total = $data[1];
        $total = floatval(str_replace(',', '', $total));
        $dataHoaDon = [
          'MaKH' => Auth::id(),
            'TrangThai' => 'Chờ xác nhận'
        ];
        $hd = $this->hoadon_service->store($dataHoaDon);
        if($hd){
            $dataThanhToan = [
              'MaND' => 1,
                'MaHD' => $hd->MaHD,
                'NgayThanhToan' => time(),
                'TongTien' => $total,
                'PhuongThuc' => 1
            ];
            $tt = $this->thanhtoan_service->store($dataThanhToan);
            foreach ($listProducts as $item){
                $dataCTHD = [
                  'MaSP' => $item['id'],
                    'MaHD' => $hd->MaHD,
                    'SoLuong' => $item['qty'],
                    'Gia' => $item['price']
                ];
                $cthd = $this->cthoadon_service->store($dataCTHD);
            }
            Cart::destroy();
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('frontend::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('frontend::edit');
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
