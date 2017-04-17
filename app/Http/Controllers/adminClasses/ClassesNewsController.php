<?php

namespace App\Http\Controllers\adminClasses;

use App\Base\BaseFunc;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class ClassesNewsController extends Controller
{
    public function classesdangerNews()
    {
        $desc=Input::only('desc');
        $data['desc']= Input::only('desc');
        if(isset($desc["desc"]))
        {
           if(strcmp($desc['desc'],"物品")==0)
            {
            $data["DangerData"]=DB::table('log')
            ->where('log_info',1)
            ->where('log_company',session('now_company'))
            ->where('log_classes',session("now_classes"))
            ->orderBy('log_goods_name','asc')
            ->paginate(10);
            }
            if(strcmp($desc['desc'],"时间")==0)
            {
            $data["DangerData"]=DB::table('log')
            ->where('log_info',1)
            ->where('log_company',session('now_company'))
            ->where('log_classes',session("now_classes"))
            ->orderBy('log_time','desc')
            ->paginate(10);
            }
            if(strcmp($desc['desc'],"领用")==0)
            {
            $data["DangerData"]=DB::table('log')
            ->where('log_info',1)
            ->where('log_company',session('now_company'))
            ->where('log_classes',session("now_classes"))
            ->orderBy('log_user','asc')
            ->paginate(12);
            } 
        }
        else
        {
            $data["DangerData"]=DB::table("log")    
            ->where("log_info","=",1)
            ->where('log_company',session('now_company'))
            ->where('log_classes',session("now_classes"))
            ->orderBy('log_time','desc')
            ->paginate(10); 
        }
        return view("classesdangernews",$data,compact('DangerData','desc'));
    }

    public function classesnormalNews()
    {
            $desc = Input::only('desc');
            $data['desc']= Input::only('desc');
            if(isset($desc["desc"]))
            {
                if (strcmp($desc['desc'], "物品") == 0)
                {
                $data["NormalData"] = DB::table('log')
                ->where('log_info', 2)
                ->where('log_company', session('now_company'))
                ->where('log_classes', session("now_classes"))
                ->orderBy('log_goods_name', 'asc')
                ->paginate(10);
                }
                if (strcmp($desc['desc'], "时间") == 0)
                {
                $data["NormalData"] = DB::table('log')
                ->where('log_info', 2)
                ->where('log_company', session('now_company'))
                ->where('log_classes', session("now_classes"))
                ->orderBy('log_time', 'desc')
                ->paginate(10);
                }
                if (strcmp($desc['desc'], "领用") == 0)
                {
                $data["NormalData"] = DB::table('log')
                ->where('log_info', 2)
                ->where('log_company', session('now_company'))
                ->where('log_classes', session("now_classes"))
                ->orderBy('log_user', 'asc')
                ->paginate(10);
                }
            }
            else
            {
                $data["NormalData"]=DB::table("log")
                    ->where("log_info","=",2)
                    ->where('log_company',session('now_company'))
                    ->where('log_classes',session("now_classes"))
                    ->orderBy('log_time','desc')
                    ->paginate(10);
            }
            return view("Home.AdminClasses.classesnormalnews",$data,compact('NormalData','desc'));
    }

    public function searchClassesdangerPerson()
    {
        $desc = Input::only('desc');
        $data['desc']= Input::only('desc');
        $userName = Input::only("log_user");
        if(isset($desc["desc"]))
        {
           if(strcmp($desc['desc'],"物品")==0)
            {
            $data["DangerData"]=DB::table('log')
            ->where('log_info',1)
            ->where('log_company',session('now_company'))
            ->where('log_classes',session("now_classes"))
            ->orderBy('log_goods_name','asc')
            ->paginate(10);
            }
            if(strcmp($desc['desc'],"时间")==0)
            {
            $data["DangerData"]=DB::table('log')
            ->where('log_info',1)
            ->where('log_company',session('now_company'))
            ->where('log_classes',session("now_classes"))
            ->orderBy('log_time','desc')
            ->paginate(10);
            }
            if(strcmp($desc['desc'],"领用")==0)
            {
            $data["DangerData"]=DB::table('log')
            ->where('log_info',1)
            ->where('log_company',session('now_company'))
            ->where('log_classes',session("now_classes"))
            ->orderBy('log_user','asc')
            ->paginate(10);
            } 
        }
        else
        {
            $DangerData = DB::table('log')->where('log_info',"=",1)
                ->where('log_company', session('now_company'))
                ->where('log_classes', session("now_classes"))
                ->where("log_user","like","%".$userName["log_user"]."%")
                ->orderBy('log_time', 'desc')
                ->paginate(10);
        }
        return view("classesdangernews",$data,compact('DangerData','desc','userName'));
    }

    public function searchClassesnormalPerson()
    {
        $desc = Input::only('desc');
        $data['desc']= Input::only('desc');
        $userName = Input::only("log_user");
            if(isset($desc["desc"]))
            {
                if (strcmp($desc['desc'], "物品") == 0)
                {
                $data["NormalData"] = DB::table('log')
                ->where('log_info', 2)
                ->where('log_company', session('now_company'))
                ->where('log_classes', session("now_classes"))
                ->orderBy('log_goods_name', 'asc')
                ->paginate(10);
                }
                if (strcmp($desc['desc'], "时间") == 0)
                {
                $data["NormalData"] = DB::table('log')
                ->where('log_info', 2)
                ->where('log_company', session('now_company'))
                ->where('log_classes', session("now_classes"))
                ->orderBy('log_time', 'desc')
                ->paginate(10);
                }
                if (strcmp($desc['desc'], "领用") == 0)
                {
                $data["NormalData"] = DB::table('log')
                ->where('log_info', 2)
                ->where('log_company', session('now_company'))
                ->where('log_classes', session("now_classes"))
                ->orderBy('log_user', 'asc')
                ->paginate(10);
                }
            }
            else
            {
                $NormalData = DB::table('log')->where('log_info',"=",2)
                    ->where('log_company', session('now_company'))
                    ->where('log_classes', session("now_classes"))
                    ->where("log_user","like","%".$userName["log_user"]."%")
                    ->orderBy('log_time', 'desc')
                    ->paginate(10);
            }
        return view("Home.AdminClasses.classesnormalnews",$data,compact('NormalData','desc','userName'));
    }

}
