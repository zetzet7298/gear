<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class CTHoaDon extends Model
{
    protected $table ='cthoadon';
    public $timestamps = false;
    public $primaryKey = 'MaCTHD';
    protected $fillable = [
      'MaCTHD','MaHD','MaSP','SoLuong','Gia'
    ];
}
