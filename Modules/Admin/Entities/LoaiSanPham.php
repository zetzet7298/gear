<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class LoaiSanPham extends Model
{
    public $timestamps = false;
    public $primaryKey = 'MaLoaiSP';
    protected $table = 'loaisanpham';
}
