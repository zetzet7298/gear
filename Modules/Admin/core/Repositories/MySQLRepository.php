<?php


namespace Modules\Admin\core\Repositories;

use Modules\common\components\mysql\DB_driver;

class MySQLRepository extends EloquentRepository implements IMysqlRepository
{
    protected $db;
    public function __construct()
    {
        $this->db = new DB_driver();
    }
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return \Modules\Admin\Entities\LoaiSanPham::class;
    }
    public function store($data)
    {
        return $this->db->insert('loaisanpham',$data);
    }
    public function show($id)
    {
        return $this->db->get_row('select * from loaisanpham where MaLoaiSP = '.$id);
    }
    public function destroy($id)
    {
        $where = 'MaLoaiSP = '.$id;
        return $this->db->remove('loaisanpham',$where);
    }
    public function update($id, $data)
    {
        $where = 'MaLoaiSP = '.$id;
        return $this->db->update('loaisanpham',$data,$where);
    }
    public function getAll()
    {
        return $this->db->get_list('select * from loaisanpham');
    }
}