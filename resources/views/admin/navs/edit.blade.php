{{-- 繼承admin模板 --}}
@extends('layouts.admin')

{{-- 此為admin模板中content部分 --}}
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 修改導航欄 - {{ $field['nav_name'] }}
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/navs/create')}}"><i class="fa fa-plus"></i>添加導航</a>
                <a href="{{url('admin/navs')}}"><i class="fa fa-recycle"></i>導航欄列表</a>
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
        <form action="{{ url('admin/navs/'.$field['nav_id']) }}" method="post">
            {{csrf_field()}}
            {{-- 使用 PUT 方法 --}}
            {{-- 或是使用 {{ method_field('PUT') }} --}}
            <input type='hidden' name='_method' value='put' >

            <table class="add_tab">
                <tbody>
                    <tr>
                        <th>名稱：</th>
                        <td>
                            <input type="text" name="nav_name" value="{{ $field['nav_name'] }}">
                        </td>
                    </tr>
                    <tr>
                        <th>別稱：</th>
                        <td>
                            <input type="text" class="lg" name="nav_alias" value="{{ $field['nav_alias'] }}">
                        </td>
                    </tr>
                    <tr>
                        <th>連結：</th>
                        <td>
                            <input type="text" class="lg" name="nav_url" value="{{ $field['nav_url'] }}">
                        </td>
                    </tr>
                    <tr>
                        <th></i>排序：</th>
                        <td>
                            <input type="text" class="sm" name="nav_order" value="{{ $field['nav_order'] }}">
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

@endsection