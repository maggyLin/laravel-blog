<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\Http\Model\Links;

class LinksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //GET admin/links  //全部友情連結列表

        $data=Links::orderBy('link_order')->get();
        return view('admin.links.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //GET admin/links/create  到添加link頁面
        return view('admin.links.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //POST admin/links  添加link

        $input = Input::except('_token');
        //使用validation驗證
        //要求規則
        $rules = [ 
            'link_name' => 'required',
            'link_title' => 'required',
            'link_url' => 'required',
            'link_order' => 'required',
        ];

        //自訂錯誤訊息
        $message = [
            'link_name.required' => '欄位不能為空!',
            'link_title.required' => '欄位不能為空!',
            'link_url.required' => '欄位不能為空!',
            'link_order.required' => '欄位不能為空!',
        ];

        $check = Validator::make($input,$rules,$message);

        if( $check -> passes() ){ //驗證是否通過

            $re = Links::create($input);
            if($re) return redirect('admin/links');
            else back() -> with('errors','新增失敗');
        }
        else{
            //withErrors() 直接使用內建回傳錯誤方法
            return back()-> withErrors($check);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //GET admin/links/{id}/edit  指定id 連結內容
        $field = Links::find($id);
        return view('admin/links/edit' , compact('field') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //PUT admin/links/{id}  更新link內容
        $input = Input::except('_token','_method');

        //使用validation驗證
        //要求規則
        $rules = [ 
            'link_name' => 'required',
            'link_title' => 'required',
            'link_url' => 'required',
            'link_order' => 'required',
        ];

        //自訂錯誤訊息
        $message = [
            'link_name.required' => '欄位不能為空!',
            'link_title.required' => '欄位不能為空!',
            'link_url.required' => '欄位不能為空!',
            'link_order.required' => '欄位不能為空!',
        ];

        $check = Validator::make($input,$rules,$message);

        if( $check -> passes() ){ //驗證是否通過

            //批量赋值 ( post過來的ary資料跟資料表欄位名稱相同,可直接使用批量赋值 ),注意model保護欄位 guarded or fillable
            $re = Links::where('link_id',$id) -> update($input);

            if($re) return redirect('admin/links');
            else back() -> with('errors','修改失敗');
            
        }
        else{
            //withErrors() 直接使用內建回傳錯誤方法
            return back()-> withErrors($check);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         //DELETE admin/links/{id}  刪除link

         $re = Links::where('link_id',$id) -> delete(); //刪除資料
 
         if($re){
             $data = [ 'status'=>1 , 'msg'=>'刪除成功' ];
         }
         else{
             $data = [ 'status'=>0 , 'msg'=>'刪除失敗' ];
         }
         return $data;
    }

    //修改排序
    public function changeLinkOrder()  
    {
        $input = Input::all();

        $link = Links::find($input['link_id']); //找到對應id資料
        $link -> link_order =  $input['link_order']; //修改此筆的order
        $re = $link -> update();
        if($re){
            $data = [ 'status'=>1 , 'msg'=>'排序更新成功' ];
        }
        else{
            $data = [ 'status'=>0 , 'msg'=>'排序更新失敗' ];
        }

        return $data;

    }


}
