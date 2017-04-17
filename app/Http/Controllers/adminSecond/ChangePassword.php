<?php
/**
 * Created by PhpStorm.
 * User: Silence
 * Date: 2016/11/8
 * Time: 9:31
 */
namespace App\Http\Controllers\adminSecond;

use App\Base\BaseFunc;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;


class ChangePassword extends Controller
{
    public function change(BaseFunc $baseFunc)
    {

     $input=Request::only('admin_second_password');
        $password['admin_second_password']=md5($input['admin_second_password']);
        $change=DB::table("admin_second")
            ->where("admin_second_ids",session("admin"))
            ->update($password);
        if($change)
        {
            $baseFunc -> setRedirectMessage(true,"修改密码成功，请牢记密码",NULL,"/secondAdmins");
        }
        else
        {
            $baseFunc -> setRedirectMessage(false,"修改密码失败",NULL,"/secondAdmins");
        }
    }
}