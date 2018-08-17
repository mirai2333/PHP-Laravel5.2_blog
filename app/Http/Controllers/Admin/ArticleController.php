<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    //get.admin/article  全部文章
    public function index()
    {
        $data = Article::orderBy("art_id", "desc")->paginate(10);
        return view("admin.article.index", compact("data"));
    }

    //get.admin/article/create    添加文章
    public function create()
    {
        $data = (new Category())->tree();
        return view("admin.article.add", compact("data"));
    }

    //post.admin/article    添加分类提交方法
    public function store()
    {
        $input = Input::except(["fileselect", "_token"]);
        $input["art_time"] = time();
        $rules = [
            "art_title" => "required",
            "art_content" => "required"
        ];
        $message = [
            "art_title.required" => "文章名称是必须的！",
            "art_content.required" => "文章内容是必须的！"
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->passes()) {
            $result = Article::create($input);
            if ($result) {
                return redirect("admin/article");
            } else {
                return back()->with("errors", "文章添加失败！");
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    //get.admin/article/{article}/edit    编辑文章
    public function edit($art_id)
    {
        $field = Article::find($art_id);
        $data = (new Category())->tree();
        return view("admin.article.edit", compact("field", "data"));
    }

    //put.admin/article/{article}    更新分类
    public function update($art_id)
    {
        $input = Input::except("_token", "_method", "fileselect");
        $result = Article::where("art_id",$art_id)->update($input);
        if ($result) {
            return redirect("admin/article");
        } else {
            return back()->with("errors", "文章更新失败！");
        }
    }

    //delete.admin/article/{article}    删除文章
    public function destroy($art_id){
        $result = Article::where("art_id",$art_id)->delete();
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
