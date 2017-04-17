<?php

namespace App\Http\Controllers\adminSecond;

use App\Base\BaseFunc;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SecondLogout extends Controller
{
    //
    public function logout(BaseFunc $baseFunc){
        session(["admin"=>NULL]);
	return view("Home.AdminSeconds.start");
        //$baseFunc->setRedirectMessage(true,"已登出",NULL,"/start");
    }
}
