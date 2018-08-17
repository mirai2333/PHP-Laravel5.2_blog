<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    public function upload()
    {
        $file = Input::file("file");
        if ($file->isValid()){
            $extension = $file->getClientOriginalExtension();
            $newName = date("YmdHis").mt_rand(100,999).".".$extension;
            $path = $file->move(base_path()."/uploads",$newName);
            return "uploads/".$newName;
        }
    }
}
