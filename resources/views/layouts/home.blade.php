<!doctype html>
<html>
<head>
<meta charset="utf-8">

@yield('info')
{{--  根據不同頁面不同
  <title>陈华个人博客</title>
<meta name="keywords" content="个人博客模板,博客模板" />
<meta name="description" content="寻梦主题的个人博客模板，优雅、稳重、大气,低调。" /> --}}


<link href="{{url('resources/views/home/css/base.css')}}" rel="stylesheet">
<link href="{{url('resources/views/home/css/index.css')}}" rel="stylesheet"> <!-- index 使用-->
<link href="{{url('resources/views/home/css/style.css')}}" rel="stylesheet"> <!-- list 使用 -->
<link href="{{url('resources/views/home/css/new.css')}}" rel="stylesheet"> <!-- new 使用 -->
<!--[if lt IE 9]>
<script src="js/modernizr.js"></script>
<![endif]-->
</head>
<body>

<header>
  <div id="logo"><a href="{{url('/')}}"></a></div>
  <nav class="topnav" id="topnav">
    @foreach ($navs as $item)
      <a href="{{$item->nav_url}}"><span>{{$item->nav_name}}</span><span class="en">{{$item->nav_alias}}</span></a>
    @endforeach
  </nav>
</header>

{{-- 表示是匯入admin模板後,可編輯部分 --}}
{{-- @yield('content') --}}
@section('content')
<h3>
  <p>最新<span>文章</span></p>
</h3>
<ul class="rank">
  @foreach ($new as $item)
  <li><a href="{{url('a/'.$item->art_id)}}" title="{{$item->art_title}}">{{$item->art_title}}</a></li>
  @endforeach
</ul>
<h3 class="ph">
  <p>点击<span>排行</span></p>
</h3>
<ul class="paih">
  @foreach ($hot as $item)
  <li><a href="{{url('a/'.$item->art_id)}}" title="{{$item->art_title}}">{{$item->art_title}}</a></li>
  @endforeach
</ul>
@show

<footer>
  <p>
    {{-- 讀取配置項 config/web.php --}}
    {!! Config::get('web.copyright') !!}
  </p>
</footer>
{{-- <script src="{{url('resources/views/home/js/silder.js')}}"></script> --}}




</body>
</html>
