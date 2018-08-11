<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once "resources\org\code\Code.class.php";

class LoginController extends Controller
{


    public function login()
    {
        if ($input = Input::all()){
            $code_actual = new \Code();
            $code_actual = $code_actual->get();
            if ($code_actual != strtoupper($input["code"])){
                return back()->with("msg","验证码错误");
            }
            $user = User::first();
            if ($user->user_name != $input["user_name"]
                || Crypt::decrypt($user->user_pass) != $input["user_pass"]){
                return back()->with("msg","用户名或者密码错误！");
            }

            session(["user"=>$user]);
            return redirect("admin/index");
        }else{
            return view("admin.login");
        }
    }

    public function code()
    {
        $code = new \Code();
        return $code->make();
    }

    public function quit(){
        session(["user"=>null]);
        return redirect("admin/login");
    }
}
