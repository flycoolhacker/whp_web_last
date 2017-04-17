<?php
/**
 * Created by PhpStorm.
 * User: Silence
 * Date: 2016/9/22
 * Time: 15:08
 */
namespace App\Http\Controllers\adminSecond;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class NewsController extends Controller
{
    public function dangerNews() //危化品日志
    {
        $KSclass=Input::only('KS_select');
        $desc = Input::only('desc');
        $data['desc']= Input::only('desc');
        if(isset($KSclass["KS_select"]))
        {
            if($KSclass["KS_select"]==0)
            {
                $data["DangerData"]=DB::table("log")
                    ->where("log_info","=",1)
                    ->where('log_company',session('now_company'))
                    ->orderBy('log_time','desc')
                    ->paginate(12);
                if(strcmp($desc["desc"],"时间")==0)
                {
                    $data["DangerData"]=DB::table("log")
                        ->where("log_info","=",1)
                        ->where('log_company',session('now_company'))
                        ->orderBy('log_time','desc')
                        ->paginate(12);
                }
                if(strcmp($desc["desc"],"物品")==0)
                {
                    $data["DangerData"]=DB::table("log")
                        ->where("log_info","=",1)
                        ->where('log_company',session('now_company'))
                        ->orderBy('log_goods_name','asc')
                        ->paginate(12);
                }
		        if(strcmp($desc["desc"],"领用")==0)
            	{
                    $data["DangerData"]=DB::table("log")
                        ->where("log_info","=",1)
                        ->where('log_company',session('now_company'))
                        ->orderBy('log_user','asc')
                        ->paginate(12);
            	}

            }
            else
            {
                $data["DangerData"]=DB::table("log")
                    ->where("log_info","=",1)
                    ->where('log_company',session('now_company'))
                    ->where("log_classes","=",$KSclass)
                    ->paginate(12);
                if(strcmp($desc["desc"],"时间")==0)
                {
                    $data["DangerData"]=DB::table("log")
                        ->where("log_info","=",1)
                        ->where('log_company',session('now_company'))
                        ->where("log_classes","=",$KSclass)
                        ->orderBy('log_time','desc')
                        ->paginate(12);
                }
                if(strcmp($desc["desc"],"物品")==0)
                {
                    $data["DangerData"]=DB::table("log")
                        ->where("log_info","=",1)
                        ->where('log_company',session('now_company'))
                        ->where("log_classes","=",$KSclass)
                        ->orderBy('log_goods_name','asc')
                        ->paginate(12);
                }
		        if(strcmp($desc["desc"],"领用")==0)
           	    {
                    $data["DangerData"]=DB::table("log")
                        ->where("log_info","=",1)
                        ->where('log_company',session('now_company'))
                        ->where("log_classes","=",$KSclass)
                        ->orderBy('log_user','asc')
                        ->paginate(12);
                }

            }
        }
        else
        {
            $data["DangerData"]=DB::table("log")
                ->where("log_info","=",1)
                ->where('log_company',session('now_company'))
                ->orderBy('log_time','desc')
                ->paginate(12);
            if(strcmp($desc["desc"],"时间")==0)
            {
                $data["DangerData"]=DB::table("log")
                    ->where("log_info","=",1)
                    ->where('log_company',session('now_company'))
                    ->orderBy('log_time','desc')
                    ->paginate(12);
            }
            if(strcmp($desc["desc"],"物品")==0)
            {
                $data["DangerData"]=DB::table("log")
                    ->where("log_info","=",1)
                    ->where('log_company',session('now_company'))
                    ->orderBy('log_goods_name','asc')
                    ->paginate(12);
            }
            if(strcmp($desc["desc"],"领用")==0)
            {
                $data["DangerData"]=DB::table("log")
                    ->where("log_info","=",1)
                    ->where('log_company',session('now_company'))
                    ->orderBy('log_user','asc')
                    ->paginate(12);
            }
        }

        $ClassesData=DB::table("classes")
                    ->where('classes_company',session('now_company'))
                    ->get();
        $data["nowClasses"] = DB::table("classes")
                    ->where("classes_name","=",$KSclass)
                    ->where('classes_company',session('now_company'))
                    ->get();
        $data["log_account_master"]=DB::table("admin_classes")
            ->leftJoin("log","log_account_master","=","admin_classes_id")
            ->get();
        $data["log_mcmater_master"]=DB::table("admin_classes")
            ->leftJoin("log","log_mcmater_master","=","admin_classes_id")
            ->get();
        $data["log_user"]=DB::table("admin_classes")
            ->leftJoin("log","log_user","=","admin_classes_id")
            ->get();
        $data["log_use_master"]=DB::table("admin_classes")
            ->leftJoin("log","log_use_master","=","admin_classes_id")
            ->get();
        return view("Home.AdminSeconds.dangernews",$data,compact('ClassesData','KSclass'));
    }

    public function normalNews()  //常规品日志
    {
        $KSclass=Input::only('KS_select');
        $desc = Input::only('desc');
        $data['desc']= Input::only('desc');
        if(isset($KSclass["KS_select"]))
        {
            if($KSclass["KS_select"]==0)
            {
                $data["NormalData"]=DB::table("log")
                    ->where("log_info","=",2)
                    ->where('log_company',session('now_company'))
                    ->orderBy('log_time','desc')
                    ->paginate(12);
                if(strcmp($desc["desc"],"时间")==0)
                {
                    $data["NormalData"]=DB::table("log")
                        ->where("log_info","=",2)
                        ->where('log_company',session('now_company'))
                        ->orderBy('log_time','desc')
                        ->paginate(12);
                }
                if(strcmp($desc["desc"],"物品")==0)
                {
                    $data["NormalData"]=DB::table("log")
                        ->where("log_info","=",2)
                        ->where('log_company',session('now_company'))
                        ->orderBy('log_goods_name','asc')
                        ->paginate(12);
                }
                if(strcmp($desc["desc"],"领用")==0)
                {
                    $data["NormalData"]=DB::table("log")
                        ->where("log_info","=",2)
                        ->where('log_company',session('now_company'))
                        ->orderBy('log_user','asc')
                        ->paginate(12);
                }
            }
            else
            {
                $data["NormalData"]=DB::table("log")
                    ->where("log_info","=",2)
                    ->where("log_classes","=",$KSclass)
                    ->where('log_company',session('now_company'))
                    ->paginate(12);
                if(strcmp($desc["desc"],"时间")==0)
                {
                    $data["NormalData"]=DB::table("log")
                        ->where("log_info","=",2)
                        ->where("log_classes","=",$KSclass)
                        ->where('log_company',session('now_company'))
                        ->orderBy('log_time','desc')
                        ->paginate(12);
                }
                if(strcmp($desc["desc"],"物品")==0)
                {
                    $data["NormalData"]=DB::table("log")
                        ->where("log_info","=",2)
                        ->where("log_classes","=",$KSclass)
                        ->where('log_company',session('now_company'))
                        ->orderBy('log_goods_name','asc')
                        ->paginate(12);
                }
		if(strcmp($desc["desc"],"领用")==0)
                {
                    $data["NormalData"]=DB::table("log")
                        ->where("log_info","=",2)
                        ->where("log_classes","=",$KSclass)
                        ->where('log_company',session('now_company'))
                        ->orderBy('log_user','asc')
                        ->paginate(12);
                }

            }
        }
        else
        {
            $data["NormalData"]=DB::table("log")
                ->where("log_info","=",2)
                ->where('log_company',session('now_company'))
                ->orderBy('log_time','desc')
                ->paginate(12);
            if(strcmp($desc["desc"],"时间")==0)
            {
                $data["NormalData"]=DB::table("log")
                    ->where("log_info","=",2)
                    ->where('log_company',session('now_company'))
                    ->orderBy('log_time','desc')
                    ->paginate(12);
            }
            if(strcmp($desc["desc"],"物品")==0)
            {
                $data["NormalData"]=DB::table("log")
                    ->where("log_info","=",2)
                    ->where('log_company',session('now_company'))
                    ->orderBy('log_goods_name','asc')
                    ->paginate(12);
            }
	    if(strcmp($desc["desc"],"领用")==0)
                {
                    $data["NormalData"]=DB::table("log")
                        ->where("log_info","=",2)
                        ->where('log_company',session('now_company'))
                        ->orderBy('log_user','asc')
                        ->paginate(12);
                }

        }
        $data["nowClasses"] = DB::table("classes") 
                       ->where("classes_name","=",$KSclass)
                       ->where('classes_company',session('now_company'))
                       ->get();
        $data["ClassesData"]=DB::table("classes")
                       ->where('classes_company',session('now_company'))
                       ->get();
        $data["log_use_master"]=DB::table("admin_classes")
                       ->leftJoin("log","log_use_master","=","admin_classes_id")
                       ->get();
        $data["log_user"]=DB::table("admin_classes")
                       ->leftJoin("log","log_user","=","admin_classes_id")
                       ->get();
        return view("Home.AdminSeconds.normalnews",$data,compact('ClassesData','KSclass'));
    }

}