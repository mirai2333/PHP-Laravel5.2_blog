<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table="blog_category";
    protected $primaryKey="cate_id";
    public $timestamps=false;
    protected $guarded=[];

    public function tree(){
        $categories = $this->orderBy("cate_order","asc")->get();
        return $this->getTree($categories);
    }

    //还附带了排序的时候先把父类目按顺序输出，再把子类目按顺序输出！！！
    public function getTree($data){
        $arr = array();
        foreach ($data as $k=>$v){
            if ($v->cate_pid==0){
                $data[$k]["_cate_name"] =$data[$k]["cate_name"];
                $arr[] = $data[$k];
                foreach ($data as $m=>$n) {
                    if ($n->cate_pid == $v->cate_id){
                        $data[$m]["_cate_name"] = "💨💨".$data[$m]["cate_name"];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }
}
