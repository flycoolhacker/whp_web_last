<?php namespace App\Http\Controllers\AdminTop;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use App\Base\BaseFunc;
/**
 * Created by PhpStorm.
 * User: Silence
 * Date: 2016/10/9
 * Time: 11:41
 */

class AdminTopLoginController extends Controller
{
    public function login()
    {
        return view("/Home.AdminTops.adminTopLogin");
    }
    public function _login(BaseFunc $baseFunc)
    {
        //$baseMassage = new BaseFunc();
        $inputData = Request::only("admin_top_ids","admin_top_password");

        //$userData = DB::table("admin_top")
          //  ->where("admin_top_ids","=",$inputData["admin_top_ids"])
            //->where("admin_top_password","=",md5($inputData["admin_top_password"]))
            //->first();

        if($inputData["admin_top_ids"]==123456 && $inputData["admin_top_password"]==123456)
        {
            session(["user" => 1 ]);//session是一个包装方法，可以把数组数据写入$_SESSION
            $baseFunc -> setRedirectMessage(true, "登陆成功", NULL, "/company");
        }
        else
        {
            $baseFunc -> setRedirectMessage(false, "用户名或密码错误", NULL, "/adminTopLogin" );
        }
    }
}