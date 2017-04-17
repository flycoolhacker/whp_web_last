<?php

namespace App\Http\Controllers\adminClasses;

use App\Base\BaseFunc;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ClassesLogout extends Controller
{
    //
    public function logout(BaseFunc $baseFunc){
        session(["classes"=>NULL]);
	return view("Home.AdminSeconds.start");
        //$baseFunc->setRedirectMessage(true,"已登出",NULL,"/start");
    }
}
