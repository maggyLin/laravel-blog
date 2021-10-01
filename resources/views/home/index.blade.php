{{-- 繼承home.blade模板 --}}
@extends('layouts.home')

{{-- 針對頁面修改模板 home.blade info區塊 --}}
@section('info')
{{-- 讀取配置項 config/web.php --}}
<title>{{Config::get('web.web_title')}} - {{Config::get('web.seo_title')}}</title>
<meta name="keywords" content="{{Config::get('web.keywords')}}" />
<meta name="description" content="{{Config::get('web.description')}}" />
@endsection

{{-- 此為home.blade模板中content部分 --}}
@section('content')

<div class="banner">
  <section class="box">
    <ul class="texts">
      <p>打了死结的青春，捆死一颗苍白绝望的灵魂。</p>
      <p>为自己掘一个坟墓来葬心，红尘一梦，不再追寻。</p>
      <p>加了锁的青春，不会再因谁而推开心门。</p>
    </ul>
    <div class="avatar"><a href="#"><span>陈华</span></a> </div>
  </section>
</div>
<div class="template">
  <div class="box">
    <h3>
      <p><span>个人博客</span>站長推薦</p>
    </h3>
    <ul>
      @foreach ($pics as $item)
      <li><a href="{{url('a/'.$item->art_id)}}"><img src="{{url( $item->art_thumb)}}"></a><span>{{$item->art_title}}</span></li>
      @endforeach
    </ul>
  </div>
</div>
<article>
  <h2 class="title_tj">
    <p>文章<span>推荐</span></p>
  </h2>
  <div class="bloglist left">

    @foreach ($data as $item)
    <h3>{{$item->art_title}}</h3>
    <figure><img src="{{url( $item->art_thumb)}}"></figure>
    <ul>
      <p>{{$item->art_description}}</p>
      <a title="{{$item->art_title}}" href="{{url('a/'.$item->art_id)}}" class="readmore">阅读全文>></a>
    </ul>
    <p class="dateview"><span>{{date('Y-m-d' , $item->art_time)}}</span><span>作者:{{$item->art_editor}}</span></p>
    @endforeach
    {{-- 分頁 --}}
    <div class="page">
      {{-- 使用 paginate 分頁方式 --}}
      {{ $data -> links() }}
    </div>

  </div>

  <aside class="right">
    <div class="weather"><iframe width="250" scrolling="no" height="60" frameborder="0" allowtransparency="true" src="http://i.tianqi.com/index.php?c=code&id=12&icon=1&num=1"></iframe></div>
    <div class="news">
    
    {{-- home.blade模板 @show --}}
    @parent

    <h3 class="links">
      <p>友情<span>链接</span></p>
    </h3>
    <ul class="website">
      @foreach ($links as $item)
      <li><a href="{{$item->link_url}}" target="_black">{{$item->link_name}}</a></li>
      @endforeach
    </ul> 
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

