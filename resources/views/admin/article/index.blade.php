{{-- 繼承admin模板 --}}
@extends('layouts.admin')

{{-- 此為admin模板中content部分 --}}
@section('content')


<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 全部文章
</div>
<!--面包屑导航 结束-->

<!--结果页快捷搜索框 开始-->
<div class="search_wrap">
        <form action="" method="post">
            {{csrf_field()}}
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        <select onchange="">
                            <option value="">全部</option>
                            @foreach ($cate_data as $item)
                                <option value="{{$item['id']}}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </td>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
<!--结果页快捷搜索框 结束-->

<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <!--快捷导航 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th class="tc">ID</th>
                    <th>分類</th>
                    <th>标题</th>
                    <th>点击</th>
                    <th>发布人</th>
                    <th>更新时间</th>
                    <th>操作</th>
                </tr>

                @foreach ($data as $item)
                    <tr>
                        <td class="tc">{{$item -> art_id}}</td>
                        <td>{{$item -> c_name}}</td>
                        <td>
                            <a href="#">{{$item -> art_title}}</a>
                        </td>
                        <td>{{$item -> art_view}}</td>
                        <td>{{$item -> art_editor}}</td>
                        <td>{{$item -> updated_at}}</td>
                        <td>
                            <a href="{{url('admin/article/'.$item -> art_id.'/edit')}}">修改</a>
                            <a href="javascript:" onclick="delArt( {{$item -> art_id}} )">删除</a>
                        </td>
                    </tr>
                @endforeach
            </table>

            <div class="page_list">
                {{-- 使用 paginate 分頁方式 --}}
                {{ $data -> links() }}
            </div>

        </div>
    </div>
</form>
<!--搜索结果页面 列表 结束-->

<style>
    /* paginate style 微調 */
    .result_content ul li span{
        font-size: 15px;
        padding: 6px 12px;
    }
</style>

<script >
    //刪除文章
    function delArt(art_id){
        
        layer.confirm('確定要刪除此文章', {
            btn: ['確定','取消'] //按钮
        }, function(){
            //對應btn[0]

            $.post( 
                "{{ url('admin/article/') }}/"+art_id,
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