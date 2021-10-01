<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // 指定primary key名稱 (預設為id)
    protected $primaryKey = 'user_id';

    //自定義資料庫名稱
    // protected $table='blog_user';
    
    //不要使用updated_at created_at
    // public $timestamps = false;
}
