{{-- 繼承admin模板 --}}
@extends('layouts.admin')

{{-- 此為admin模板中content部分 --}}
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 添加文章
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>全部文章</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    {{-- validation驗證是否回傳錯誤檢查 --}}
    {{-- 使用 withErrors (驗證錯誤) 回傳為object --}}
    @if(is_object($errors))  
        @foreach($errors->all() as $error)
            <p style="color:red">{{$error}}</p>
        @endforeach
    @else
        {{-- 使用back() -> with()回傳訊息 --}}
        <p style="color:red">{{$errors}}</p>
    @endif
    
    <div class="result_wrap">
        <form action="{{ url('admin/article') }}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120">分类：</th>
                        <td>
                            <select name="cate_id">
                                @foreach ($data as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                @endforeach  
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章标题：</th>
                        <td>
                            <input type="text" class="lg" name="art_title">
                            <span><i class="fa fa-exclamation-circle yellow"></i>必填</span>
                            <p>标题可以写100个字</p>
                        </td>
                    </tr>
                    <tr>
                        <th>編輯者：</th>
                        <td>
                            <input type="text" class="lg" name="art_editor">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>缩略图：</th>
                        <td>
                            <input type="hidden" name="art_thumb" value="" >
                            <input type="file" name="img_info" accept="image/jpeg, image/png">
                            <br>
                            <img id="uploadImg" src="" alt="" style="max-width: 300px; max-height:100px;">
                        </td>
                    </tr>
                    <tr>
                        <th>關鍵字：</th>
                        <td>
                            <input type="text" class="lg" name="art_tag">
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="art_description"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>文章內容：</th>
                        <td>
                            <textarea name="art_content"></textarea>
                        </td>
                    </tr>
                    
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

    <script>
        //獲取圖片
        $("input[name='img_info']").on("change",function(){
            let fileImg = $(this)[0].files[0];
            // console.log('fileImg :>> ', fileImg);

            var file_data = new FormData();

            let csrf_token = "{{csrf_token()}}";

            file_data.append("img", fileImg);
            file_data.append("_token", csrf_token);

            $.ajax({
                type : "POST",
                url : "{{url('admin/upload')}}",
                data : file_data,
                cache : false,
                processData : false,
                contentType : false
            }).done(function(data) {
                console.log('data :>> ', data);

                if(data==0){ //php存取失敗
                    layer.msg('圖片上傳失敗');
                }
                else{
                    $("input[name='art_thumb']").attr("value",data); 
                    $('#uploadImg').attr('src','http://localhost/111_pratice/laravelDemo/blog/'+data); //顯示圖片
                }

            }).fail(function(data) {
                console.log('up load img fail');
            });

        });
    </script>

@endsection