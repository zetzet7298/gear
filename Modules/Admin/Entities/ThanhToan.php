<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class ThanhToan extends Model
{
    protected $table = 'thanhtoan';
    public $timestamps = false;
    public $primaryKey = 'MaTT';
    public $fillable = [
      'MaTT','MaND','MaHD','NgayThanhToan','TongTien','PhuongThuc'
    ];
}
