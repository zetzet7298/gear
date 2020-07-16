<?php

namespace Modules\FrontEnd\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\core\Services\ProductESService;
use Modules\common\components\mysql\DB_driver;
use Cart;
class FrontEndController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    protected $esService;
    protected $service;
    public function __construct(ProductESService $esService)
    {
        $this->esService = $esService;
        $this->service = new DB_driver;
    }

    public function detail($id){
        return \response()->json($this->esService->show($id));
    }

    public function getUser(){
        $id = Auth::id();
        $user = $this->service->get_row('select * from users where id = '.$id);
        return \response()->json($user);
    }

    public function updateSoLuong(Request $request){
        $data = $request->all();
        foreach ($data as $item){
            Cart::update($item['rowId'],$item['qty']);
        }
        return \response()->json(Cart::subTotal());
    }

    public function postLogin(Request $request){
        $login = [
          'username' => $request->username,
            'password' => $request->password
        ];
        if(Auth::attempt($login)){
            return redirect('/');
        }else{
            return redirect()->back()->with('status', 'Tài khoản hoặc mật không chính xác');
        }
    }

    public function login(){
        return View('frontend::user.login');
    }

    public function logout(){
        Auth::logout();
        return View('frontend::user.login');
    }

    public function detailView(){
        return View('frontend::product.detail');
    }

    public function index()
    {
        return view('frontend::product.index');
    }

    public function cart(){
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
