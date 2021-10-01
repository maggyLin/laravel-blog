{{-- 繼承admin模板 --}}
@extends('layouts.admin')

{{-- 此為admin模板中content部分 --}}
@section('content')


<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 全部分類
</div>
<!--面包屑导航 结束-->

<!--结果页快捷搜索框 开始-->
{{-- <div class="search_wrap">
        <form action="" method="post">
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        <select onchange="javascript:location.href=this.value;">
                            <option value="">全部</option>
                            <option value="http://www.baidu.com">百度</option>
                            <option value="http://www.sina.com">新浪</option>
                        </select>
                    </td>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div> --}}
<!--结果页快捷搜索框 结束-->

<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <!--快捷导航 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>添加分類</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th class="tc" width='5%'>排序</th>
                    <th class="tc" width='5%'>ID</th>
                    <th>分類名稱</th>
                    <th>标题</th>
                    <th>查看次數</th>
                    <th>操作</th>
                    <th>更新时间</th>
                </tr>

                @foreach ($data as $item)

                    <tr>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{$item -> id}})" value="{{$item -> order}}">
                        </td>
                        <td class="tc">{{$item -> id}}</td>
                        <td>
                            <a href="#"> {{$item -> name}} </a>
                        </td>
                        <td>{{$item -> title}}</td>
                        <td>{{$item -> view}}</td>
                        <td>
                            <a href=" {{url('admin/category/'.$item -> id.'/edit')}} ">修改</a>
                            <a href="javascript:" onclick="delCate( {{$item -> id}} )" >删除</a>
                        </td>
                        <td>{{$item -> updated_at}}</td>
                    </tr>
                    
                @endforeach

            </table>

            {{-- <div class="page_nav">
                <div>
                    <a class="first" href="/wysls/index.php/Admin/Tag/index/p/1.html">第一页</a>
                    <a class="prev" href="/wysls/index.php/Admin/Tag/index/p/7.html">上一页</a>
                    <a class="num" href="/wysls/index.php/Admin/Tag/index/p/6.html">6</a>
                    <a class="num" href="/wysls/index.php/Admin/Tag/index/p/7.html">7</a>
                    <span class="current">8</span>
                    <a class="num" href="/wysls/index.php/Admin/Tag/index/p/9.html">9</a>
                    <a class="num" href="/wysls/index.php/Admin/Tag/index/p/10.html">10</a>
                    <a class="next" href="/wysls/index.php/Admin/Tag/index/p/9.html">下一页</a>
                    <a class="end" href="/wysls/index.php/Admin/Tag/index/p/11.html">最后一页</a>
                    <span class="rows">11 条记录</span>
                </div>
            </div>

            <div class="page_list">
                <ul>
                    <li class="disabled"><a href="#">&laquo;</a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul>
            </div> --}}


        </div>
    </div>
</form>
<!--搜索结果页面 列表 结束-->

<script>

    //修改排序
    function changeOrder(obj,cate_id){

        var cate_order = $(obj).val(); //輸入數值
        $.post( 
            "{{ url('admin/cate/changeOrder') }}",
            {
                '_token':'{{csrf_token()}}',
                'cate_id':cate_id,
                'cate_order':cate_order
            }, 
            function(data){
                // alert(data.msg);
                layer.msg(data.msg); //使用Layer套件彈出視窗
            }
        )

    }

    //刪除分類
    function delCate(cate_id){
        
        layer.confirm('確定要刪除此分類', {
            btn: ['確定','取消'] //按钮
        }, function(){
            //對應btn[0]

            $.post( 
                "{{ url('admin/category/') }}/"+cate_id,
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