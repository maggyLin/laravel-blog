{{-- 繼承admin模板 --}}
@extends('layouts.admin')

{{-- 此為admin模板中content部分 --}}
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 修改連結內容 - {{ $field['link_name'] }}
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>添加連結</a>
                <a href="{{url('admin/links')}}"><i class="fa fa-recycle"></i>連結列表</a>
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
        <form action="{{ url('admin/links/'.$field['link_id']) }}" method="post">
            {{csrf_field()}}
            {{-- 使用 PUT 方法 --}}
            {{-- 或是使用 {{ method_field('PUT') }} --}}
            <input type='hidden' name='_method' value='put' >

            <table class="add_tab">
                <tbody>
                    <tr>
                        <th>連結名稱：</th>
                        <td>
                            <input type="text" name="link_name" value="{{ $field['link_name'] }}">
                        </td>
                    </tr>
                    <tr>
                        <th>連結标题：</th>
                        <td>
                            <input type="text" class="lg" name="link_title" value="{{ $field['link_title'] }}">
                            <p>标题可以写100个字</p>
                        </td>
                    </tr>
                    <tr>
                        <th>連結：</th>
                        <td>
                            <input type="text" class="lg" name="link_url" value="{{ $field['link_url'] }}">
                        </td>
                    </tr>
                    <tr>
                        <th></i>排序：</th>
                        <td>
                            <input type="text" class="sm" name="link_order" value="{{ $field['link_order'] }}">
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