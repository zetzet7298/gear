<?php


namespace Modules\Admin\core\Repositories;


interface IEloquentRepository
{
    public function paginate($number);
    public function show($id);
    public function store($data);
    public function update($id,$data);
    public function destroy($id);
    public function getAll();
    public function getAllLoaiSP();
    public function getAllThuongHieu();
}