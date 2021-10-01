<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{   

    protected $guarded=[]; 

    public function tree()
    {   
        //使用order欄位排序
        $cate = $this -> orderBy('order') -> get();
        $data = $this -> getTree($cate); //排序子分類在父分類後面
        return $data;
    }
    
    //整理排序內容
    public function getTree($data)
    {   
        $arr = array();
        foreach($data as $item){
            if($item -> pid==0){  //先把大項抓出來
                $arr[]=$item;

                foreach($data as $item2){  // 小項的父級層級(pid)等於目前大項的id跟在後面
                    if($item2 -> pid == $item -> id){
                        $arr[]=$item2;        
                    }
                }
            }
        }
        return $arr;
    }

}
