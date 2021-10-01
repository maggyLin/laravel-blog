<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    // 指定primary key名稱 (預設為id)
    protected $primaryKey = 'art_id';
    //自定義資料庫名稱
    protected $table='article';

    protected $guarded=[]; 

    
}
