<?php

namespace App\Http\Controllers;

use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;

class ViewController extends Controller
{
    public function index(){
//        $data = [
//          'name'=>'毛泽东',
//          'age'=>26
//        ];
//        $title = "中华人民共和国万岁！！";
//        return view('my_laravel',compact('data','title'));

//        $str = "123456";
//        echo Crypt::encrypt($str);
        $user = User::first();
        dd($user);
    }
}
