<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends Controller
{
    //get.admin/navs  全部文章
    public function index()
    {
        $data = Navs::orderBy("nav_order","asc")->get();
        return view("admin.navs.index",compact("data"));
    }


    public function changeOrder()
    {
        $input = Input::all();
        $navs = Navs::find($input["nav_id"]);
        $navs->nav_order = $input["nav_order"];
        $result = $navs->update();
        if ($result){
            $data=[
                "status"=>"1",
                "msg"=>"导航修改成功！"
            ];
        }else{
            $data=[
                "status"=>"0",
                "msg"=>"导航修改失败！"
            ];
        }
        return $data;
    }

    //get.admin/category/{category}    显示单个分类信息
    public function show($cate_id){
        $data = Category::find($cate_id);
    }

    //get.admin/navs/create    添加导航
    public function create(){
        return view("admin.navs.add",compact("data"));
    }
    //post.admin/navs    添加导航提交方法
    public function store(){
        if($input = Input::except("_token")){
            $rules=[
                "nav_name"=>"required",
                "nav_url"=>"required"
            ];
            $message=[
                "nav_name.required"=>"导航名称是必须的！",
                "nav_url.required"=>"导航URL是必须的！"
            ];
            $validator = Validator::make($input,$rules,$message);
            if ($validator->passes()){
                $result = Navs::create($input);
                if ($result){
                    return redirect("admin/navs");
                }else{
                    return back()->with("errors","添加导航失败！");
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return view("admin.category.add")->with("errors","没有接收到数据！");
        }
    }

    //get.admin/navs/{navs}/edit    编辑链接
    public function edit($nav_id){
        $field = Navs::find($nav_id);
        return view("admin.navs.edit",compact("field"));
    }
    //put.admin/navs/{navs}    更新导航
    public function update($nav_id){
        $input = Input::except("_token","_method");
        $result = Navs::where("nav_id",$nav_id)->update($input);
        if ($result){
            return redirect("admin/navs");
        }else{
            return back()->with("errors","导航更新失败！");
        }
    }


    //delete.admin/navs/{navs}    删除导航
    public function destroy($nav_id){
        $result = Navs::where("nav_id",$nav_id)->delete();
        if ($result){
            $data=[
                "status"=>"1",
                "msg"=>"删除成功！"
            ];
        }else{
            $data=[
                "status"=>"0",
                "msg"=>"删除失败！"
            ];
        }
        return $data;
    }
}
