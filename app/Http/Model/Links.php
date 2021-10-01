<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    // 指定primary key名稱 (預設為id)
    protected $primaryKey = 'link_id';
    protected $guarded=[]; 

    
}
