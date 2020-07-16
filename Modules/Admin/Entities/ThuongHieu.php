<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class ThuongHieu extends Model
{
    public $timestamps = false;
    public $primaryKey = 'MaThuongHieu';
    protected $table = 'thuonghieu';
}
