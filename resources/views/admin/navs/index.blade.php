{{-- 繼承admin模板 --}}
@extends('layouts.admin')

{{-- 此為admin模板中content部分 --}}
@section('content')


<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 導航列表
</div>
<!--面包屑导航 结束-->


<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <!--快捷导航 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/navs/create')}}"><i class="fa fa-plus"></i>添加導航</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th class="tc" width='5%'>排序</th>
                    <th class="tc">ID</th>
                    <th>名稱</th>
                    <th>別名</th>
                    <th>連結</th>
                    <th>操作</th>
                </tr>

                @foreach ($data as $item)
                    <tr>
                        <td class="tc">
                            <input type="text" onchange="changeNavOrder(this,{{$item -> nav_id}})" value="{{$item -> nav_order}}">
                        </td>
                        <td class="tc">{{$item -> nav_id}}</td>
                        <td>{{$item -> nav_name}}</td>
                        <td>{{$item -> nav_alias}}</td>
                        <td>{{$item -> nav_url}}</td>
                        <td>
                            <a href="{{url('admin/navs/'.$item -> nav_id.'/edit')}}">修改</a>
                            <a href="javascript:" onclick="delNav( {{$item -> nav_id}} )">删除</a>
                        </td>
                    </tr>
                @endforeach
            </table>

        </div>
    </div>
</form>


<script >
    //修改排序
    function changeNavOrder(obj,id){

        var order = $(obj).val(); //輸入數值
        $.post( 
            "{{ url('admin/navs/changeNavOrder') }}",
            {
                '_token':'{{csrf_token()}}',
                'nav_id':id,
                'nav_order':order
            }, 
            function(data){
                // alert(data.msg);
                layer.msg(data.msg); //使用Layer套件彈出視窗
            }
        )

    }

    //刪除文章
    function delNav(id){
        
        layer.confirm('確定要刪除此連結嗎?', {
            btn: ['確定','取消'] //按钮
        }, function(){
            //對應btn[0]

            $.post( 
                "{{ url('admin/navs/') }}/"+id,
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