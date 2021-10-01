<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="{{ asset('resources/views/admin/style/css/ch-ui.admin.css') }}">
	<link rel="stylesheet" href="{{ asset('resources/views/admin/style/font/css/font-awesome.min.css') }}">
	<script type="text/javascript" src="{{ asset('resources/views/admin/style/js/jquery.js') }}"></script>
	<script type="text/javascript" src="{{ asset('resources/views/admin/style/js/ch-ui.admin.js') }}"></script>
	<script type="text/javascript" src="{{ asset('resources/org/layer/layer.js') }}"></script>
</head>
<body>

		
	<!--头部 开始-->
	<div class="top_box">
		<div class="top_left">
			<div class="logo">后台管理模板</div>
			<ul>
				<li><a href="{{url('admin/index')}}" class="active">首页</a></li>
				{{-- <li><a href="{{url('admin/index')}}">管理页</a></li> --}}
			</ul>
		</div>
		<div class="top_right">
			<ul>
				<li>管理员：admin</li>
				<li><a href="{{url('admin/pass')}}" target="main">修改密码</a></li>
				<li><a href="{{url('admin/quit')}}">退出</a></li>
			</ul>
		</div>
	</div>
	<!--头部 结束-->

	<!--左侧导航 开始-->
	<div class="menu_box">
		<ul>
			<li>
				<h3><i class="fa fa-fw fa-clipboard"></i>內容管理</h3>
				<ul class="sub_menu">
					<li><a href="{{url('admin/category/create')}}" ><i class="fa fa-fw fa-plus-square"></i>添加分類</a></li>
					<li><a href="{{url('admin/category')}}" ><i class="fa fa-fw fa-list-ul"></i>分類列表</a></li>
					<li><a href="{{url('admin/article/create')}}"><i class="fa fa-fw fa-list-alt"></i>添加文章</a></li>
					<li><a href="{{url('admin/article')}}"><i class="fa fa-fw fa-image"></i>文章列表</a></li>
				</ul>
			</li>
			<li>
				<h3><i class="fa fa-fw fa-cog" ></i>系统设置</h3>
				<ul class="sub_menu" style="display: block;">
					<li><a href="{{url('admin/links')}}" ><i class="fa fa-fw fa-list-ul"></i>友情連結列表</a></li>
					<li><a href="{{url('admin/navs')}}" ><i class="fa fa-fw fa-list-ul"></i>導航欄列表</a></li>
					<li><a href="{{url('admin/config')}}" ><i class="fa fa-fw fa-list-ul"></i>配置列表</a></li>
				</ul>
			</li>
			<li>
				<h3><i class="fa fa-fw fa-thumb-tack"></i>工具导航</h3>
				<ul class="sub_menu">
					<li><a href="https://fontawesome.com/v4.7.0/icons/" target="main"><i class="fa fa-fw fa-font"></i>图标调用</a></li>
					<li><a href="http://hemin.cn/jq/cheatsheet.html" target="main"><i class="fa fa-fw fa-chain"></i>Jquery手册</a></li>
					<li><a href="http://tool.c7sky.com/webcolor/" target="main"><i class="fa fa-fw fa-tachometer"></i>配色板</a></li>
					<li><a href="element.html" target="main"><i class="fa fa-fw fa-tags"></i>其他组件</a></li>
				</ul>
			</li>
		</ul>
	</div>
	<!--左侧导航 结束-->

	<div class="main_box">
    
		{{-- 表示是匯入admin模板後,可編輯部分 --}}
		@yield('content')
	
	</div>

</body>
</html>