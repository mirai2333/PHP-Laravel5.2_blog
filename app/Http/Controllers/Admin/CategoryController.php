<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //get.admin/category  全部分类列表
    public function index(){
        $data = (new Category())->tree();
        return view('admin.category.index')->with("data",$data);
    }

    public function changeOrder()
    {
        $input = Input::all();
        $cate = Category::find($input["cate_id"]);
        $cate->cate_order = $input["cate_order"];
        $result = $cate->update();
        if ($result){
            $data=[
                "status"=>"1",
                "msg"=>"分类修改成功！"
            ];
        }else{
            $data=[
                "status"=>"0",
                "msg"=>"分类修改失败！"
            ];
        }
        return $data;
    }



    //get.admin/category/create    添加分类
    public function create(){
        $data = Category::where("cate_pid",0)->get();
        return view("admin.category.add",compact("data"));
    }
    //post.admin/category    添加分类提交方法
    public function store(){
        if($input = Input::except("_token")){
            $rules=[
                "cate_name"=>"required"
            ];
            $message=[
                "cate_name.required"=>"分类名称是必须的！"
            ];
            $validator = Validator::make($input,$rules,$message);
            if ($validator->passes()){
                $result = Category::create($input);
                if ($result){
                    return redirect("admin/category");
                }else{
                    return back()->with("errors","添加分类失败！");
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return view("admin.category.add")->with("errors","没有接收到数据！");
        }
    }

    //get.admin/category/{category}/edit    编辑分类
    public function edit($cate_id){
        $field = Category::find($cate_id);
        $data = Category::where("cate_pid",0)->get();
        return view("admin.category.edit",compact("field","data"));
    }
    //put.admin/category/{category}    更新分类
    public function update($cate_id){
        $input = Input::except("_token","_method");
        $result = Category::where("cate_id",$cate_id)->update($input);
        if ($result){
            return redirect("admin/category");
        }else{
            return back()->with("errors","分类信息更新失败！");
        }
    }
    //get.admin/category/{category}    显示单个分类信息
    public function show(){

    }

    //delete.admin/category/{category}    删除单个分类
    public function delete(){

    }



}
