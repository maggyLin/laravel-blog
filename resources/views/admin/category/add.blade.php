{{-- 繼承admin模板 --}}
@extends('layouts.admin')

{{-- 此為admin模板中content部分 --}}
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 添加分類
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/category')}}"><i class="fa fa-recycle"></i>全部分類</a>
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
        <form action="{{ url('admin/category') }}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120">父級分类：</th>
                        <td>
                            <select name="pid">
                                {{-- 固定, 成為父級分類 (pid=0) --}}
                                <option value="0">頂級分類</option> 
                                {{-- 目前現有父級分類, 選取後會成為目前選取項目下面子分類 --}}
                                @foreach ($data as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                @endforeach  
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>分類名稱：</th>
                        <td>
                            <input type="text" name="name">
                            <span><i class="fa fa-exclamation-circle yellow"></i>必填</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>分類标题：</th>
                        <td>
                            <input type="text" class="lg" name="title">
                            <span><i class="fa fa-exclamation-circle yellow"></i>必填</span>
                            <p>标题可以写30个字</p>
                        </td>
                    </tr>
                    <tr>
                        <th>關鍵字：</th>
                        <td>
                            <textarea name="keyword"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="description"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>排序：</th>
                        <td>
                            <input type="text" class="sm" name="order">
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


                    {{-- <tr>
                        <th><i class="require">*</i>缩略图：</th>
                        <td><input type="file" name=""></td>
                    </tr>
                    <tr>
                        <th>单选框：</th>
                        <td>
                            <label for=""><input type="radio" name="">单选按钮一</label>
                            <label for=""><input type="radio" name="">单选按钮二</label>
                        </td>
                    </tr>
                    <tr>
                        <th>复选框：</th>
                        <td>
                            <label for=""><input type="checkbox" name="">复选框一</label>
                            <label for=""><input type="checkbox" name="">复选框二</label>
                        </td>
                    </tr>
                    
                    <tr>
                        <th>详细内容：</th>
                        <td>
                            <textarea class="lg" name="content"></textarea>
                            <p>标题可以写30个字</p>
                        </td>
                    </tr> --}}


                </tbody>
            </table>
        </form>
    </div>

@endsection