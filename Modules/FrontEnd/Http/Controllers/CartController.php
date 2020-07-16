<?php

namespace Modules\FrontEnd\Http\Controllers;

use Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admin\core\Services\ProductESService;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    protected $es_service;
    public function __construct(ProductESService $es_service)
    {
        $this->es_service = $es_service;
    }

    public function content(){
        $content = Cart::content();
        return \response()->json($content);
    }

    public function count(){
        return Cart::count();
    }

    public function total(){
        return Cart::subtotal();
    }

    public function delete($rowId){
        Cart::remove($rowId);
        $content = Cart::content();
        return \response()->json($content);
    }

    public function add($MaSP){
        $product = $this->es_service->show($MaSP);
        $data = [
            'id' => $product['MaSP'],
            'name' => $product['TenSP'],
            'qty' => 1,
            'price' => $product['Gia'],
            'options'=>[
                'Thumbnail' => $product['Thumbnail']
            ]
        ];
        Cart::add($data);
    }

    public function index()
    {
        return view('frontend::cart.index');
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
        dd($request->MaSP);
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
