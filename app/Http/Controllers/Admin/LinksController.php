<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends Controller
{
    //get.admin/links  全部文章
    public function index()
    {
        $data = Links::orderBy("link_order","asc")->get();
        return view("admin.links.index",compact("data"));
    }


    public function changeOrder()
    {
        $input = Input::all();
        $links = Links::find($input["link_id"]);
        $links->link_order = $input["link_order"];
        $result = $links->update();
        if ($result){
            $data=[
                "status"=>"1",
                "msg"=>"友情链接修改成功！"
            ];
        }else{
            $data=[
                "status"=>"0",
                "msg"=>"友情链接修改失败！"
            ];
        }
        return $data;
    }

    //get.admin/category/{category}    显示单个分类信息
    public function show($cate_id){
        $data = Category::find($cate_id);
    }

    //get.admin/links/create    添加友情链接
    public function create(){
        return view("admin.links.add",compact("data"));
    }
    //post.admin/links    添加友情链接提交方法
    public function store(){
        if($input = Input::except("_token")){
            $rules=[
                "link_name"=>"required",
                "link_url"=>"required"
            ];
            $message=[
                "link_name.required"=>"友情链接名称是必须的！",
                "link_url.required"=>"友情链接URL是必须的！"
            ];
            $validator = Validator::make($input,$rules,$message);
            if ($validator->passes()){
                $result = Links::create($input);
                if ($result){
                    return redirect("admin/links");
                }else{
                    return back()->with("errors","添加友情链接失败！");
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return view("admin.category.add")->with("errors","没有接收到数据！");
        }
    }

    //get.admin/links/{links}/edit    编辑链接
    public function edit($link_id){
        $field = Links::find($link_id);
        return view("admin.links.edit",compact("field"));
    }
    //put.admin/links/{links}    更新友情链接
    public function update($link_id){
        $input = Input::except("_token","_method");
        $result = Links::where("link_id",$link_id)->update($input);
        if ($result){
            return redirect("admin/links");
        }else{
            return back()->with("errors","友情链接更新失败！");
        }
    }


    //delete.admin/links/{links}    删除友情链接
    public function destroy($link_id){
        $result = Links::where("link_id",$link_id)->delete();
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
