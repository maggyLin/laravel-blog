{{-- 繼承admin模板 --}}
@extends('layouts.admin')

{{-- 此為admin模板中content部分 --}}
@section('content')


<!--主体部分 开始-->

{{-- <iframe src=" {{url('admin/info')}} " frameborder="0" width="100%" height="100%" name="main"></iframe>  --}}
@include('admin/info')

<!--主体部分 结束-->

<!--底部 开始-->
<div class="bottom_box">
	CopyRight © 2016. Powered By <a href="http://www.chenhua.club">http://www.chenhua.club</a>.
</div>
<!--底部 结束-->


@endsection
