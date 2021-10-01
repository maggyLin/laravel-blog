<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Http\Model\Categories;

class CategoryController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //GET admin/category  全部分類列表

        //在Categories model中自訂一方法不可以用 Categories::tree() (除非使用public static)
        //使用實例化 new
        $data = (new Categories) -> tree(); 

        return view('admin.category.index') -> with('data' , $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //GET admin/category/create  到添加分類頁面
        
        //抓取目前現有的父級分類 pid ==0
        $data = Categories::where('pid',0) -> get();

        return view('admin.category.add' , compact('data') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //POST admin/category  添加分類

        // $input = Input::all();
        $input = Input::except('_token'); //取得除了_token以外的值

        //使用validation驗證
        //要求規則
        $rules = [ 
            'name' => 'required|between:1,10',
            'title' => 'required|between:1,200',
        ];

        //自訂錯誤訊息
        $message = [
            'name.required' => '欄位不能為空!',
        ];

        $check = Validator::make($input,$rules,$message);

        if( $check -> passes() ){ //驗證是否通過

            //批量赋值 ( post過來的ary資料跟資料表欄位名稱相同,可直接使用批量赋值 ),注意model保護欄位 guarded or fillable
            $re = Categories::create($input);

            if($re) return redirect('admin/category');
            else back() -> with('errors','新增失敗');
            

            //使用DB方式
            // $re = DB::insert('insert into `categories` (`pid`, `name`, `title`, `keyword`, `description`, `order`) values (?, ?, ?, ?, ?, ?)' , [
            //     $input['pid'] , $input['name'] , $input['title'] , $input['keyword'] , $input['description'] , $input['order']
            // ]);
            // dd($re);

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
        //GET admin/category/{category} 顯示單個分類訊息
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //GET admin/category/{category}/edit  指定id分類

        $field = Categories::find($id);
        // dd($data);

        //抓取目前現有的父級分類 pid ==0
        $data = Categories::where('pid',0) -> get();

        return view('admin/category/edit' , compact('data','field') );
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
        //PUT admin/category/{category}  更新分類內容

        // $input = Input::all();
        $input = Input::except('_token','_method'); //取得除了 _token, _method 以外的值

        //使用validation驗證
        //要求規則
        $rules = [ 
            'name' => 'required|between:1,10',
            'title' => 'required|between:1,200',
        ];

        //自訂錯誤訊息
        $message = [
            'name.required' => '欄位不能為空!',
        ];

        $check = Validator::make($input,$rules,$message);

        if( $check -> passes() ){ //驗證是否通過

            //批量赋值 ( post過來的ary資料跟資料表欄位名稱相同,可直接使用批量赋值 ),注意model保護欄位 guarded or fillable
            $re = Categories::where('id',$id) -> update($input);

            if($re) return redirect('admin/category');
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
        //DELETE admin/category/{category}  刪除分類

        $re = Categories::where('id',$id) -> delete(); //刪除資料

        Categories::where('pid',$id) -> update(['pid'=>0]); //將刪除分類下面的子級分類調成頂級分類pid=0

        if($re){
            $data = [ 'status'=>1 , 'msg'=>'刪除成功' ];
        }
        else{
            $data = [ 'status'=>0 , 'msg'=>'刪除失敗' ];
        }
        return $data;
    }

    //修改類型排序
    public function changeOrder()  
    {
        $input = Input::all();

        $cate = Categories::find($input['cate_id']); //找到對應id資料
        $cate -> order =  $input['cate_order']; //修改此筆的order
        $re = $cate -> update();
        if($re){
            $data = [ 'status'=>1 , 'msg'=>'排序更新成功' ];
        }
        else{
            $data = [ 'status'=>0 , 'msg'=>'排序更新失敗' ];
        }

        return $data;

    }

}
