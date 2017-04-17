<?php namespace App\Http\Controllers\adminSecond;
use App\Base\BaseFunc;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;


/**
 * Created by PhpStorm.
 * User: Silence
 * Date: 2016/9/4
 * Time: 16:05
 */

class StartController extends Controller
{
    public function ReStart()
    {
        session(["Yes"=>"yes"]);
        return view("Home.AdminSeconds.warn");
    }
    public function Start()
    {
        $id = Request::only("card_id");
        //dump($id);die;

        return view("Home.AdminSeconds.start",$id);
    }



    public function SecondAdminLogin(BaseFunc $baseFunc)
    {
        $inputData = Request::only("admin_second_ids","admin_second_password");

        //dump($inputData);die;
        $userData = DB::table("admin_second")
            ->where("admin_second_ids","=",$inputData["admin_second_ids"])
            ->where("admin_second_password","=",md5($inputData["admin_second_password"]))
            ->first();

        if($userData!=NULL)
        {
            session(["now_company" => $userData->admin_second_company ]);//获得登录账户所在单位的ID
            session(["admin" => $userData->admin_second_ids ],["company" => $userData->admin_second_company ]);//session是一个包装方法，可以把数组数据写入$_SESSION
            //dump(session("company"));die;
            $baseFunc -> setRedirectMessage(true, "登陆成功", NULL, "/admin");
        }
        elseif($userData == NULL)
        {
            $baseFunc -> setRedirectMessage(false, "用户名或密码错误", NULL, "/start" );
        }
    }

}