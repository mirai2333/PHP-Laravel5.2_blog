<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    //get.admin/config  全部文章
    public function index()
    {
        $data = Config::orderBy("conf_order","asc")->get();
        return view("admin.config.index",compact("data"));
    }


    public function changeOrder()
    {
        $input = Input::all();
        $config = Config::find($input["conf_id"]);
        $config->conf_order = $input["conf_order"];
        $result = $config->update();
        if ($result){
            $data=[
                "status"=>"1",
                "msg"=>"配置项修改成功！"
            ];
        }else{
            $data=[
                "status"=>"0",
                "msg"=>"配置项修改失败！"
            ];
        }
        return $data;
    }

    //get.admin/category/{category}    显示单个分类信息
    public function show($cate_id){
        $data = Category::find($cate_id);
    }

    //get.admin/config/create    添加配置项
    public function create(){
        return view("admin.config.add",compact("data"));
    }
    //post.admin/config    添加配置项提交方法
    public function store(){
        if($input = Input::except("_token")){
            $rules=[
                "conf_name"=>"required",
                "conf_title"=>"required"
            ];
            $message=[
                "conf_name.required"=>"配置项名称是必须的！",
                "conf_title.required"=>"配置项标题是必须的！"
            ];
            $validator = Validator::make($input,$rules,$message);
            if ($validator->passes()){
                $result = Config::create($input);
                if ($result){
                    return redirect("admin/config");
                }else{
                    return back()->with("errors","添加配置项失败！");
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return view("admin.category.add")->with("errors","没有接收到数据！");
        }
    }

    //get.admin/config/{config}/edit    编辑链接
    public function edit($conf_id){
        $field = Config::find($conf_id);
        return view("admin.config.edit",compact("field"));
    }
    //put.admin/config/{config}    更新配置项
    public function update($conf_id){
        $input = Input::except("_token","_method");
        $result = Config::where("conf_id",$conf_id)->update($input);
        if ($result){
            return redirect("admin/config");
        }else{
            return back()->with("errors","配置项更新失败！");
        }
    }


    //delete.admin/config/{config}    删除配置项
    public function destroy($conf_id){
        $result = Config::where("conf_id",$conf_id)->delete();
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
