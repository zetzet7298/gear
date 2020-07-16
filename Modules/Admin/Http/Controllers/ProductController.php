<?php

namespace Modules\Admin\Http\Controllers;

use App\Helpers\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admin\core\Repositories\ProductRepository;
use Modules\Admin\core\Services\ProductCacheService;
use Modules\Admin\core\Services\ProductESService;
use Modules\Admin\core\Services\ProductService;
use Modules\Admin\Entities\Product;
use Modules\Admin\Http\Requests\CreateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    protected $service;
    protected $product_service;
    protected $es_service;
    public function __construct(ProductCacheService $service, ProductService $product_service, ProductESService $es_service)
    {
        $this->service = $service;
        $this->product_service = $product_service;
        $this->es_service = $es_service;
    }

    public function uploadImage(Request $request){

    }

    public function daxoa(){
        return View('admin::sanpham.sanphamdaxoa');
    }

    public function all(){
        $products = $this->es_service->getAll();
        return \response()->json($products);
    }

    public function allDeleted(){
        $products = $this->product_service->getAllDeleted();
        return \response()->json($products);
    }

    public function khoiphuc($id){
        $rs = $this->product_service->recovery($id);
        $products = $this->product_service->getAllDeleted();
        $service = new ProductESService();
        $service->store($id);
        return \response()->json($products);
    }

    public function search(Request $request){
        $products = $this->es_service->search($request->all());
        return \response()->json($products);
    }

    public function productByLoaiSP($maLoaiSP){
        $products = $this->es_service->productByLoaiSP($maLoaiSP);
        return \response()->json($products);
    }

    public function paginate(){
        $products = $this->es_service->paginate(10);
        return \response()->json($products);
    }

    public function index()
    {
        return view('admin::sanpham.danhsach');
    }
    public function getData(){
        $products = $this->service->getAll();
        return \response()->json($products);
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
        $image = $request->photo;
        $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        if($request->photo){
            $this->product_service->uploadImage($image);
            $request->merge(['Thumbnail'=>$name]);
        }
        $request->merge(['MaLoaiSP'=>$request->LoaiSP]);
        $request->merge(['MaThuongHieu'=>$request->ThuongHieu]);
        $store = $this->product_service->store($request->all());
        if($store){
            $service = new ProductESService();
            $service->store($store->MaSP);
            return \response()->json(['success'=>'Đã thêm!']);
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $product = $this->es_service->show($id);
        return \response()->json($product);
    }

    public function get($id){
        return view('admin::sanpham/detail');
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
        $image = $request->photo;
        $currentPhoto = $this->es_service->show($id);
        $currentPhoto = $currentPhoto['Thumbnail'];
        if($request->photo){
            $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            $this->product_service->uploadImage($image,$currentPhoto);
            $request->merge(['Thumbnail'=>$name]);
        }
        $request->merge(['MaLoaiSP'=>$request->MaLoaiSP]);
        $request->merge(['MaThuongHieu'=>$request->MaThuongHieu]);
        $update = $this->product_service->update($id,$request->except(['photo','LoaiSP','ThuongHieu']));
        $this->es_service->destroy($id);
        $this->es_service->store($id);
        if($update){
            $service = new ProductESService();
            $service->store($id);
            return \response()->json(['success'=>'Đã sửa!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        //$this->service->destroy($id);
        $this->product_service->destroy($id);
        $this->es_service->destroy($id);
    }
}
