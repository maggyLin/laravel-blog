<?php

//所有Admin中controller的模板 共用項目可以放此

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //圖片上傳
    public function upload(){
        // $input = Input::all();
        $file = Input::file("img"); //獲取圖片內容(使用file方法,傳過來為file)
        
        if( $file -> isValid() ){  //驗證文件是否有效

            $fileName = $file -> getClientOriginalName(); //上傳檔案名稱
            $extension = $file -> getClientOriginalExtension(); //檔案副檔名
            $path = $file -> getRealPath(); //緩存檔案路徑

            $newName = date('YmdHis').mt_rand(100,999).'.'.$extension; //重新命名
            $path = $file -> move(base_path().'/uploads',$newName);  //移動到資料夾根目錄(base_path)下的uploads
            $filepath = 'uploads/'.$newName;
            return $filepath;
        }
        else{
            return 0; //fail
        }

    }
}
