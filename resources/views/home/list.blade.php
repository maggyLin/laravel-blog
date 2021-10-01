{{-- 繼承home.blade模板 --}}
@extends('layouts.home')

{{-- 針對頁面修改模板 home.blade info區塊 --}}
@section('info')
<title>{{$field->name}} - {{Config::get('web.seo_title')}}</title>
<meta name="keywords" content="{{$field->keyword}}" />
<meta name="description" content="{{$field->description}}" />
@endsection

{{-- 此為home.blade模板中content部分 --}}
@section('content')

<article class="blogs">
<h1 class="t_nav">
  <span>{{$field->title}}</span>
  {{-- <a href="{{url('/')}}" class="n1">网站首页</a>
  <a href="/" class="n2">{{$field->name}}</a> --}}
</h1>
<div class="newblog left">

  @foreach ($data as $item)
    <h2>{{$item->art_title}}</h2>
    <p class="dateview"><span>发布时间：{{date('Y-m-d' , $item->art_time)}}</span><span>作者：{{$item->art_editor}}</span><span>分类：[<a>{{$field->name}}</a>]</span></p>
    <figure><img src="{{url( $item->art_thumb)}}"></figure>
    <ul class="nlist">
      <p>{{$item->art_description}}</p>
      <a title="{{$item->art_title}}" href="{{url('a/'.$item->art_id)}}" target="_blank" class="readmore">阅读全文>></a>
    </ul>
    <div class="line"></div>
  @endforeach

  <div class="page">
    {{-- 使用 paginate 分頁方式 --}}
    {{ $data -> links() }}
  </div>
</div>
<aside class="right">

  {{-- 子分類 --}}
  @if ($submenu)
  <div class="rnav">
    <ul>
      @foreach ($submenu as $index=>$item)
      <li class="rnav{{$index+1}}"><a href="{{url('cate/'.$item->id)}}">{{$item->name}}</a></li>
      @endforeach
    </ul>      
  </div>
  @endif
   
  <div class="news">
  {{-- <h3>
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
    </ul> --}}

    {{-- home.blade模板 @show --}}
    @parent

  </div>

     <!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
    <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script> 
    <script type="text/javascript" id="bdshell_js"></script> 
    <script type="text/javascript">
      document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
    </script> 
    <!-- Baidu Button END -->   
</aside>
</article>

@endsection
