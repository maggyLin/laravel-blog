<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use App\Http\Model\User;

class IndexController extends CommonController
{
    public function index(){
        return view('admin.index');
    }

    public function info(){
        return view('admin.info');
    }

    //修改密碼
    public function pass(){
        //判斷是否有傳值
        if($input = Input::all()){

            //使用validation驗證

            //要求規則
            // confirmed 會自動確認 password 與password_confirmation是否一致(前端參數名稱name要注意)
            $rules = [ 
                'password' => 'required|between:6,20|confirmed',
            ];

            //自訂錯誤訊息
            $message = [
                'password.required' => '欄位不能為空!',
                'password.between' => '新密碼必須在6-20位!',
                'password.confirmed' => '新密碼與確認密碼必須相同!',
            ];

            $check = Validator::make($input,$rules,$message);

            if( $check -> passes() ){ //驗證是否通過

                //檢查舊密碼
                $user = User::first();
                $password_now = Crypt::decrypt($user->user_password);

                if( $password_now == $input['password_o'] ){
                    $user -> user_password = Crypt::encrypt($input['password']);
                    $user -> update();

                    return back() -> with('errors','修改成功!');
                }
                else{
                    return back() -> with('errors','舊密碼輸入錯誤!');
                }

            }
            else{
                //輸出所有驗證失敗訊息
                // dd( $check -> errors() -> all() );

                //withErrors() 直接使用內建回傳錯誤方法
                return back()-> withErrors($check);
            }
            

        }
        else{
            //直接進入修改密碼畫面
            return view('admin.pass');
        }

    }


}
