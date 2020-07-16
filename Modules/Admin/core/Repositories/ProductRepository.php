<?php


namespace Modules\Admin\core\Repositories;


use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Modules\Admin\Entities\Product;

class ProductRepository extends EloquentRepository implements IProductRepository
{
    public function paginate($number)
    {
        return $this->model
            ->join('loaisanpham','loaisanpham.MaLoaiSP','sanpham.MaLoaiSP')
            ->join('thuonghieu','thuonghieu.MaThuongHieu','sanpham.MaThuongHieu')
            ->where('sanpham.deleteFlag','=',0)->paginate($number)->toArray();
    }

    public function show($id)
    {
        return $this->model->where('MaSP',$id)
            ->join('loaisanpham','loaisanpham.MaLoaiSP','sanpham.MaLoaiSP')
            ->join('thuonghieu','thuonghieu.MaThuongHieu','sanpham.MaThuongHieu')
            ->where('sanpham.deleteFlag','=',0)
            ->get()->toArray();
    }

    public function getAll()
    {
        return $this->model
            ->join('loaisanpham','loaisanpham.MaLoaiSP','sanpham.MaLoaiSP')
            ->join('thuonghieu','thuonghieu.MaThuongHieu','sanpham.MaThuongHieu')
            ->where('sanpham.deleteFlag','=',0)
            ->get()->toArray();
    }

    public function getModel()
    {
        // TODO: Implement getModel() method.
        return \Modules\Admin\Entities\Product::class;
    }
    //Phuong thuc rieng viet o day
    public function getAllDeleted()
    {
        return $this->model
            ->join('loaisanpham','loaisanpham.MaLoaiSP','sanpham.MaLoaiSP')
            ->join('thuonghieu','thuonghieu.MaThuongHieu','sanpham.MaThuongHieu')
            ->where('sanpham.deleteFlag','=',1)
            ->get()->toArray();
    }
    public function uploadImage($image, $currentPhoto = false){
        if(!is_null($image)){
            $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            $image = Image::make($image);
            $image->save(public_path('admin_asset/upload/'.$name));

            $photo = public_path('admin_asset/upload/'.$currentPhoto);
            if($currentPhoto!=false && file_exists($currentPhoto)){
                @unlink($photo);
            }
        }
    }
    public function recovery($id){
        return $this->model->find($id)->update(['deleteFlag'=>0]);
    }
}