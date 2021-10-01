<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('test', 'IndexController@index');

//前台
Route::group(['namespace' => 'Home'], function () {
    Route::get('/', 'IndexController@index');
    Route::get('/cate/{cateId}', 'IndexController@cate');  //list.blade
    Route::get('/a/{artId}', 'IndexController@article');  //new.blade
});

//後台
Route::group(['prefix' => 'admin' , 'namespace' => 'Admin'] , function () {

    Route::any('login', 'LoginController@login');
    Route::get('code', 'LoginController@code'); //產生驗證碼

    
    //check 是否已經登入成功
    Route::group(['middleware' => 'admin.login'] , function () {

        Route::any('upload', 'CommonController@upload'); //圖片上傳 

        Route::get('quit', 'LoginController@quit'); //會員退出

        Route::get('index', 'IndexController@index'); //登入成功進入首頁
        Route::get('info', 'IndexController@info');
        Route::any('pass', 'IndexController@pass'); //修改密碼

        Route::resource('category', 'CategoryController');  //文章分類,使用到增刪改查,使用REST資源控制器
        Route::post('cate/changeOrder', 'CategoryController@changeOrder'); //修改類型排序

        Route::resource('article', 'ArticleController');  //文章內容,使用到增刪改查,使用REST資源控制器

        Route::resource('links', 'LinksController');  //友情連結 
        Route::post('links/changeLinkOrder', 'LinksController@changeLinkOrder'); //修改 link 排序

        Route::resource('navs', 'NavsController');  //自定義導航
        Route::post('navs/changeNavOrder', 'NavsController@changeNavOrder'); //修改 nav 排序

        Route::resource('config', 'ConfigController');  //網站設定
        Route::post('config/changeConfigOrder', 'ConfigController@changeConfigOrder'); //修改 config 排序
        Route::post('config/changecontent', 'ConfigController@changeContent'); //修改 config 內容

    });

});





