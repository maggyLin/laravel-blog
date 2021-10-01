<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\Http\Model\Categories;
use App\Http\Model\Article;

class ArticleController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //GET admin/article  //全部文章列表

        //獲取所有分類
        $cate_data = (new Categories) -> tree();
        
        //使用Join 範例
        // $field = Article::leftJoin('Categories', 'id', '=', 'Article.cate_id') 
        //         ->where('Article.art_id',$id) 
        //         ->get(['Article.*','Categories.id as c_id','Categories.name as c_name']);

        //抓取文章資料 - 使用分頁分法 paginate
        // $data = Article::orderBy('art_id','desc')->paginate(5); 
        // dd($data -> links());  //分頁資訊(頁面顯示)

        //使用left join 抓取 分類
        $data = Article::leftJoin('Categories', 'id', '=', 'Article.cate_id') 
                ->select('Article.*','Categories.id as c_id','Categories.name as c_name')
                ->orderBy('art_id','desc')
                ->paginate(5);

        return view('admin.article.index', compact('data','cate_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //GET admin/article/create  到添加文章頁面

        $data = (new Categories) -> tree(); //獲取所有分類
        return view('admin.article.add' , compact('data') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //POST admin/article  添加文章
        $input = Input::except('_token','img_info');
        // dd($input);
        
        //使用validation驗證
        //要求規則
        $rules = [ 
            'art_title' => 'required',
            'art_thumb' => 'required',
            'art_content' => 'required',
        ];

        //自訂錯誤訊息
        $message = [
            'art_title.required' => '欄位不能為空!',
            'art_thumb.required' => '欄位不能為空!',
            'art_content.required' => '欄位不能為空!',
        ];

        $check = Validator::make($input,$rules,$message);

        if( $check -> passes() ){ //驗證是否通過

            $input['art_time'] = time();

            //批量赋值
            $re = Article::create($input);
            if($re) return redirect('admin/article');
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
        //GET admin/article/{id}/edit  指定id文章

        $data = Categories::all(); //分類
        $field = Article::find($id); //文章資料
        return view('admin/article/edit' , compact('field','data') );
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
        //PUT admin/article/{id}  更新文章內容
        $input = Input::except('_token','_method','img_info'); //取得除了 _token, _method 以外的值

        //使用validation驗證
        //要求規則
        $rules = [ 
            'art_title' => 'required',
            'art_thumb' => 'required',
            'art_content' => 'required',
        ];

        //自訂錯誤訊息
        $message = [
            'art_title.required' => '欄位不能為空!',
            'art_thumb.required' => '欄位不能為空!',
            'art_content.required' => '欄位不能為空!',
        ];

        $check = Validator::make($input,$rules,$message);

        if( $check -> passes() ){ //驗證是否通過

            $input['art_time'] = time();

            //批量赋值
            $re = Article::where('art_id',$id) -> update($input);
            if($re) return redirect('admin/article');
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
        //DELETE admin/article/{id}  刪除文章

        $re = Article::where('art_id',$id) -> delete(); //刪除資料
        if($re){
            $data = [ 'status'=>1 , 'msg'=>'刪除成功' ];
        }
        else{
            $data = [ 'status'=>0 , 'msg'=>'刪除失敗' ];
        }
        return $data;
    }
}
