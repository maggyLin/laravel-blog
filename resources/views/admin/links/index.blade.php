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
<form action="#" method="post">
    <div class="result_wrap">
        <!--快捷导航 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>添加連結</a>
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
                    <th>标题</th>
                    <th>連結</th>
                    <th>操作</th>
                </tr>

                @foreach ($data as $item)
                    <tr>
                        <td class="tc">
                            <input type="text" onchange="changeLinkOrder(this,{{$item -> link_id}})" value="{{$item -> link_order}}">
                        </td>
                        <td class="tc">{{$item -> link_id}}</td>
                        <td>{{$item -> link_name}}</td>
                        <td>{{$item -> link_title}}</td>
                        <td>{{$item -> link_url}}</td>
                        <td>
                            <a href="{{url('admin/links/'.$item -> link_id.'/edit')}}">修改</a>
                            <a href="javascript:" onclick="delLink( {{$item -> link_id}} )">删除</a>
                        </td>
                    </tr>
                @endforeach
            </table>

        </div>
    </div>
</form>


<script >
    //修改排序
    function changeLinkOrder(obj,id){

        var order = $(obj).val(); //輸入數值
        $.post( 
            "{{ url('admin/links/changeLinkOrder') }}",
            {
                '_token':'{{csrf_token()}}',
                'link_id':id,
                'link_order':order
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
                "{{ url('admin/links/') }}/"+id,
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