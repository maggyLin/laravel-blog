﻿{{-- 繼承home.blade模板 --}}
@extends('layouts.home')

{{-- 針對頁面修改模板 home.blade info區塊 --}}
@section('info')
<title>{{$field->art_title}} - {{Config::get('web.seo_title')}}</title>
<meta name="keywords" content="{{$field->art_tag}}" />
<meta name="description" content="{{$field->description}}" />
@endsection

{{-- 此為home.blade模板中content部分 --}}
@section('content')

<article class="blogs">
  <h1 class="t_nav">
    <span>{{$field->art_title}}</span>
    {{-- <a href="{{url('/')}}" class="n1">网站首页</a>
    <a href="/" class="n2">{{$field->name}}</a> --}}
  </h1>
  <div class="index_about">
    <h2 class="c_titile">{{$field->art_title}}</h2>
    <p class="box_c"><span class="d_time">发布时间：{{date('Y-m-d' , $field->art_time)}}</span><span>编辑：{{$field->art_editor}}</span><span>查看次数：{{$field->art_view}}</span></p>
    <ul class="infos">
      {!! $field->art_content !!}
    </ul>
    <div class="keybq">
    <p><span>关键字词</span>：{{$field->art_tag }}</p>
    
    </div>
    <div class="ad"> </div>
    <div class="nextinfo">
      @if ($article['pre'])
        <p>上一篇：<a href="{{url('a/'.$article['pre']->art_id)}}">{{$article['pre']->art_title }}</a></p>
      @endif
      @if ($article['next'])
      <p>下一篇：<a href="{{url('a/'.$article['next']->art_id)}}">{{$article['next']->art_title }}</a></p>
      @endif
    </div>
    <div class="otherlink">
      <h2>相关文章</h2>
      <ul>
        @foreach ($data as $index=>$item)
          {{-- 不為本篇文章 --}}
          @if ($item->art_id != $field->art_id)  
            <li><a href="{{url('a/'.$item->art_id)}}" title="{{$item->art_title}}">{{$item->art_title}}</a></li>
          @endif
        @endforeach
      </ul>
    </div>
  </div>
  <aside class="right">
    <!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
    <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script> 
    <script type="text/javascript" id="bdshell_js"></script> 
    <script type="text/javascript">
      document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
    </script> 
    <!-- Baidu Button END -->
    <div class="blank"></div>
    <div class="news">
      {{-- home.blade模板 @show --}}
      @parent
    </div>

  </aside>
</article>

@endsection
