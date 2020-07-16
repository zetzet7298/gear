<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    protected $table ='hoadon';
    public $timestamps = false;
    public $primaryKey = 'MaHD';
    protected $fillable =[
      'MaHD','TrangThai','MaKH'
    ];
}
