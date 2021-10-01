{{-- 繼承admin模板 --}}
@extends('layouts.admin')

{{-- 此為admin模板中content部分 --}}
@section('content')


<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 友情連結
</div>
<!--面包屑导航 结束-->


<!--搜索结果页面 列表 开始-->
<div class="result_wrap">
    <!--快捷导航 开始-->
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置</a>
        </div>
    </div>
    <!--快捷导航 结束-->
</div>

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
    <div class="result_content">
        <form action="{{url('admin/config/changecontent')}}" method="post">
        {{csrf_field()}}
        <table class="list_tab">
            <tr>
                <th class="tc" width='5%'>排序</th>
                <th class="tc">ID</th>
                <th>名稱</th>
                <th>标题</th>
                <th>敘述</th>
                <th>內容</th>
                <th>操作</th>
            </tr>

            @foreach ($data as $item)
                <tr>
                    <td class="tc">
                        <input type="text" onchange="changeConfigOrder(this,{{$item -> conf_id}})" value="{{$item -> conf_order}}">
                    </td>
                    <td class="tc">{{$item -> conf_id}}</td>
                    <td>{{$item -> conf_name}}</td>
                    <td>{{$item -> conf_title}}</td>
                    <td>{{$item -> conf_tips}}</td>
                    {{-- <td width='50%'>{{$item -> conf_content}}</td> --}}
                    <td width='50%'>
                        <input type="hidden" name="conf_id[]" value="{{$item->conf_id}}">
                        {!! $item->_html !!}
                    </td>
                    <td>
                        <a href="{{url('admin/config/'.$item -> conf_id.'/edit')}}">修改</a>
                        <a href="javascript:" onclick="delLink( {{$item -> conf_id}} )">删除</a>
                    </td>
                </tr>
            @endforeach
        </table>

        <div class="btn_group">
            <input type="submit" value="提交">
            <input type="button" class="back" onclick="history.go(-1)" value="返回" >
        </div>
        </form>

    </div>
</div>



<script >
    //修改排序
    function changeConfigOrder(obj,id){

        var order = $(obj).val(); //輸入數值
        $.post( 
            "{{ url('admin/config/changeConfigOrder') }}",
            {
                '_token':'{{csrf_token()}}',
                'config_id':id,
                'config_order':order
            }, 
            function(data){
                // alert(data.msg);
                layer.msg(data.msg); //使用Layer套件彈出視窗
            }
        )

    }

    //刪除文章
    function delLink(id){
        
        layer.confirm('確定要刪除此連結嗎?', {
            btn: ['確定','取消'] //按钮
        }, function(){
            //對應btn[0]

            $.post( 
                "{{ url('admin/config/') }}/"+id,
                {
                    '_token':'{{csrf_token()}}',
                    '_method':'DELETE',
                }, 
                function(data){
                    layer.msg(data.msg); //使用Layer套件彈出視窗
                    window.location.reload();
                }
            )
            
        }, function(){
            //對應btn[1]
            // layer.msg('取消刪除');
        });
    }
</script>

@endsection