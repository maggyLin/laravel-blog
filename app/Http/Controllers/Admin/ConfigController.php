<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\Http\Model\Config;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ///GET admin/config
        $data=Config::orderBy('conf_order')->get();
        foreach ($data as $k=>$v){
            switch ($v->field_type){
                case 'input':
                    $data[$k]->_html = '<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea type="text" class="lg" name="conf_content[]">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                    //1|开启,0|关闭
                    $arr = explode(',',$v->field_value);
                    $str = '';
                    foreach($arr as $m=>$n){
                        //1|开启
                        $r = explode('|',$n);
                        $c = $v->conf_content==$r[0]?' checked ':'';
                        $str .= '<input type="radio" name="conf_content[]" value="'.$r[0].'"'.$c.'>'.$r[1].'　';
                    }
                    $data[$k]->_html = $str;
                break;
            }

        }
        return view('admin.config.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //GET admin/links/create  到添加link頁面
        return view('admin.config.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //POST admin/config  添加config

        $input = Input::except('_token');
        //使用validation驗證
        //要求規則
        $rules = [ 
            'conf_name' => 'required',
            'conf_title' => 'required',
        ];

        //自訂錯誤訊息
        $message = [
            'conf_name.required' => '欄位不能為空!',
            'conf_title.required' => '欄位不能為空!',
        ];

        $check = Validator::make($input,$rules,$message);

        if( $check -> passes() ){ //驗證是否通過

            $re = Config::create($input);
            if($re) return redirect('admin/config');
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
        //GET admin/config/{id}/edit  
        $field = Config::find($id);
        return view('admin/config/edit' , compact('field') );
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
            'conf_name' => 'required',
            'conf_title' => 'required',
        ];

        //自訂錯誤訊息
        $message = [
            'conf_name.required' => '欄位不能為空!',
            'conf_title.required' => '欄位不能為空!',
        ];

        $check = Validator::make($input,$rules,$message);

        if( $check -> passes() ){ //驗證是否通過

            //批量赋值 ( post過來的ary資料跟資料表欄位名稱相同,可直接使用批量赋值 ),注意model保護欄位 guarded or fillable
            $re = Config::where('conf_id',$id) -> update($input);

            if($re) return redirect('admin/config');
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
        //DELETE admin/config/{id}  刪除

        $re = Config::where('conf_id',$id) -> delete(); //刪除資料
 
        if($re){
            $this->putFile(); //修改config/web.php 文檔
            $data = [ 'status'=>1 , 'msg'=>'刪除成功' ];
        }
        else{
            $data = [ 'status'=>0 , 'msg'=>'刪除失敗' ];
        }
        return $data;
    }

    //修改排序
    public function changeConfigOrder()  
    {
        $input = Input::all();

        $link = Config::find($input['config_id']); //找到對應id資料
        $link -> conf_order =  $input['config_order']; //修改此筆的order
        $re = $link -> update();
        if($re){
            $data = [ 'status'=>1 , 'msg'=>'排序更新成功' ];
        }
        else{
            $data = [ 'status'=>0 , 'msg'=>'排序更新失敗' ];
        }

        return $data;

    }

    //修改內容
    public function changeContent()  
    {
        $input = Input::all();
        foreach($input['conf_id'] as $k=>$v){
            Config::where('conf_id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        $this->putFile();  //產生php文檔放在config/web.php
        return back()->with('errors','配置项更新成功！');
    }

    //建立 config/web.php
    public function putFile()
    {
        $config = Config::pluck('conf_content','conf_name')->all();  //使用pluck取出需要的項目
        $path = base_path().'\config\web.php';
        $str = '<?php return '.var_export($config,true).';';
        file_put_contents($path,$str);

        //使用config文件
        // echo \Illuminate\Support\Facades\Config::get('web.web_title');
    }
}
