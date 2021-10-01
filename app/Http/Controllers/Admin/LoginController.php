<?php

namespace App\Http\Controllers\Admin;

// 同目錄下的不用使用use
// use App\Http\Controllers\Admin\CommonController;

use Illuminate\Support\Facades\Input;  //post資料抓取
use Illuminate\Support\Facades\Crypt;  //密碼加密
use App\Http\Model\User;

require_once 'resources/org/code/Code.class.php'; //驗證碼

class LoginController extends CommonController
{
    public function login(){

        //取得所有發出請求時傳入的輸入資料 Input::all()

        //如果使用post傳資料 
        if($input = Input::all()){
            $code = new \Code;
            $nowCode = $code ->get(); //獲得驗證碼
            
            //判斷驗證碼
            if( strtoupper( $input['code'] ) != $nowCode ){ 

                //back()返回上個頁面 將msg 存入session
                return back()->with('msg','驗證碼錯誤!');
            }
            
            $user = User::first();

            //check user
            // if($user->user_name == $input['user_name'] && Crypt::decrypt($user->user_password)== $input['user_password'] ){
            if($user->user_name == $input['user_name'] ){
                
                //登入成功,存入session
                session(['user'=>$user]);

                // return view('admin.index');
                return redirect('admin/index');
            }
            else{
                return back()->with('msg','帳密錯誤!');
            }

        }
        else{
            //進入登入頁面
            return view('admin.login');
        }

    }

    //會員退出回到登入頁,要清除session
    public function quit(){
    
        session(['user'=>null]);
        return redirect('admin/login');
    }

    //產生驗證碼
    public function code(){
        //產生驗證碼 - 使用require 匯入 new 要\
        $code = new \Code;
        $code ->make();
    }



}
