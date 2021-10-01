<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Model\Navs;
use Illuminate\Support\Facades\View;
use App\Http\Model\Article;
use App\Http\Model\Categories;
use App\Http\Model\Links;

class IndexController extends Controller
{   
    //建構子 進入這個controller 必定先處理
    //可以把重複需要的部分取出
    public function __construct()
    {   
        //点击量最高的5篇文章 (右側欄位-點擊排行)
        $hot = Article::orderBy('art_view','desc')->take(5)->get();

        //最新发布文章8篇 (右側欄位-最新文章)
        $new = Article::orderBy('art_time','desc')->take(8)->get();

        //導航欄項目
        $navs = Navs::all();  

        //View::share把指定變量共享到此controller下(包含子組件)所有頁面
        View::share('navs',$navs); 
        View::share('hot',$hot);
        View::share('new',$new);
    }

    public function index(){ 
        //个人博客模板-点击量最高的6篇文章（个人博客站长推荐）
        $pics = Article::orderBy('art_view','desc')->take(6)->get();

        //图文列表5篇（带分页）(文章推薦)
        $data = Article::orderBy('art_time','desc')->paginate(5);

        //友情链接
        $links = Links::orderBy('link_order','asc')->get();

        return view('home.index',compact('pics','data','links'));

    }
    
    public function cate($cate_id){
        //图文列表4篇（带分页）
        $data = Article::where('cate_id',$cate_id)->orderBy('art_time','desc')->paginate(4);

        //查看次数自增
        Categories::where('id',$cate_id)->increment('view');

        //当前分类的子分类
        $submenu = Categories::where('pid',$cate_id)->get();

        //分類訊息
        $field = Categories::find($cate_id);

        return view('home.list',compact('field','data','submenu'));
    }

    public function article($art_id){
        //抓取文章跟分類資料
        $field = Article::Join('Categories','article.cate_id','=','Categories.id')->where('art_id',$art_id)->first();

        //文章查看次数自增
        Article::where('art_id',$art_id)->increment('art_view');
        // Article::where('art_id',$art_id)->increment('art_view',5); //每次增加5

        //分類查看次數增加
        Categories::where('id',$field->cate_id)->increment('view');

        //抓取上下篇文章資料
        $article['pre'] = Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        $article['next'] = Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();

        //抓取6篇同分類文章
        $data = Article::where('cate_id',$field->cate_id)->orderBy('art_id','desc')->take(6)->get();

        return view('home.new',compact('field','article','data'));
    }
    
}
