<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    // 指定primary key名稱 (預設為id)
    protected $primaryKey = 'conf_id';
    protected $guarded=[]; 
    //自定義資料庫名稱
    protected $table='config';
}
