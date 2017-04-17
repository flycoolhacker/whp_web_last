<?php namespace App\Http\Controllers\adminClasses;
use App\Base\BaseFunc;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

/**
 * Created by PhpStorm.
 * User: Silence
 * Date: 2016/10/13
 * Time: 10:31
 */

class AdminClassesLoginController extends Controller
{
    public function login(BaseFunc $baseFunc)
    {
        $inputData = Request::only("admin_classes_ides","admin_classes_password");

        //dump($inputData);die;
        $passwd=DB::table("admin_classes")
            ->where("admin_classes_ides","=",$inputData["admin_classes_ides"])
            ->value("admin_classes_password");
        if($passwd==NULL)
        {
            $baseFunc -> setRedirectMessage(false, "没有此用户!!!", NULL, "/start" );
        }
        elseif($passwd!= NULL)
        {
            $userData=DB::table("admin_classes")->where("admin_classes_ides","=",$inputData["admin_classes_ides"])
                ->where("admin_classes_password",md5($inputData['admin_classes_password']))->first();
            if($passwd==md5($inputData['admin_classes_password'])){
                session(["now_company" => $userData->admin_classes_company ]);//获得登录账户所在单位的ID
                session(["now_classes" => $userData->admin_classes_classes ]);//获得登录账户所在科室的ID
                session(["classes" => $userData->admin_classes_name ]);//session是一个包装方法，可以把数组数据写入$_SESSION
                //dump(session("now_company"));dump(session("now_classes"));dump(session("admin"));die;
                $baseFunc -> setRedirectMessage(true, "登陆成功", NULL, "/classesperson");
            }else{
                $baseFunc -> setRedirectMessage(false, "密码错误!!!", NULL, "/start" );
            }
        }
    }
}