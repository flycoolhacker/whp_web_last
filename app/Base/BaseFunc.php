<?php
namespace App\Base;
/**
 * Created by PhpStorm.
 * User: Silence
 * Date: 2016/9/30
 * Time: 11:56
 */

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;


class BaseFunc
{

    public function __construct(){

    }


    /**
     * 在提交接收页面以后，将错误/正确提示信息保存于session，并在下一页面调用showRedirectMessage()将信息显示在指定位置
     * @access public
     * @param bool $status 正确/错误
     * @param string $message 提示信息
     * @param string $plugin 需要额外加入的页面组件，如链接按钮等，显示在信息框底部
     * @param string $redirect 如果需要顺便跳转到某个页面，可以将其url填入，如果为空，则忽略不跳转
     * @return NULL/直接跳转
     */
    public function setRedirectMessage($status, $message, $plugin = NULL, $redirect = NULL)
    {
        if (Request::ajax()) {//如果是ajax请求
            //
            return response()->json(['status' => $status, 'message' => $message, "plugin" => $plugin]);
        } else {
            Session::put("__Ajax_RedirectFunc_have", true);
            Session::flash('__Ajax_RedirectFunc_status', $status);
            Session::flash('__Ajax_RedirectFunc_message', $message);
            Session::flash('__Ajax_RedirectFunc_plugin', $plugin);
            //die;
            if ($redirect != NULL) {
                echo
                    '<script language="javascript" type="text/javascript">
                window.location.href="' . $redirect . '";
                </script> ';
            }
            return NULL;
        }
    }
}