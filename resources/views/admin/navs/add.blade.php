{{-- 繼承admin模板 --}}
@extends('layouts.admin')

{{-- 此為admin模板中content部分 --}}
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 添加導航欄項目
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_content">
            <div class="short_wrap">
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
        <form action="{{ url('admin/navs') }}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>名稱：</th>
                        <td>
                            <input type="text" name="nav_name">
                            <span><i class="fa fa-exclamation-circle yellow"></i>必填</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>別稱：</th>
                        <td>
                            <input type="text" name="nav_alias">
                            <span><i class="fa fa-exclamation-circle yellow"></i>必填</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>連結：</th>
                        <td>
                            <input type="text" class="lg"  name="nav_url">
                            <span><i class="fa fa-exclamation-circle yellow"></i>必填</span>
                        </td>
                    </tr> 
                    <tr>
                        <th><i class="require">*</i>排序：</th>
                        <td>
                            <input type="text" class="sm" name="nav_order">
                            <span><i class="fa fa-exclamation-circle yellow"></i>必填</span>
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