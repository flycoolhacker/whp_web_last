<?php

namespace App\Http\Controllers\adminSecond;

use App\Base\BaseFunc;
use App\Http\Controllers\Controller;



use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class SecondAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    return view("/Home.AdminSeconds.secondAdmins");
}

    public function searchClassesAdmin()
    {
        $userName = Input::only("admin_classes_name","admin_classes_classes");
        $now_classes=$userName["admin_classes_classes"];
        $data["SexData"] = DB::table("sex")->get();
        $data["ClassesData"] = DB::table("classes")->where("classes_company","=",session("now_company"))->get();
        $data["ClassData"] = DB::table("person_class")->get();
        $data["JobData"] = DB::table("job")->get();
        $data["SexData"] = DB::table("sex")->get();
        $data["ClassData"] = DB::table("person_class")->get();
        if($userName["admin_classes_classes"]==null){
            $data["SecondAdminData"] = DB::table("admin_classes")
                ->leftJoin("classes","classes_id","=","admin_classes_classes")
                ->where("admin_classes_company","=",session("now_company"))
                ->where("admin_classes_name","like","%".$userName["admin_classes_name"]."%")
                ->get();
        }else{
            $data["SecondAdminData"] = DB::table("admin_classes")
                ->leftJoin("classes","classes_id","=","admin_classes_classes")
                ->where("admin_classes_company","=",session("now_company"))
                ->where("admin_classes_name","like","%".$userName["admin_classes_name"]."%")
                ->where("admin_classes_classes",$now_classes)
                ->get();
        }
        return view("/Home.AdminSeconds.secondAdmins",$data,compact("now_classes"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BaseFunc $baseFunc
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function store(BaseFunc $baseFunc)
    {
        // $inputData = Input::except('_token',"admin_classes_classes");
		$inputData = Input::except('_token');
        //$admin_classes_classes=Request::only('admin_classes_classes');
        //$inputData['admin_classes_classes']=DB::table('classes')->where('classes_name',$admin_classes_classes["admin_classes_classes"])->where('classes_company',session('now_company'))->value("classes_id");
        if($inputData['admin_classes_job'] != "领用人")
        {
            $inputData['admin_classes_password']=md5(123456);
        }
        $inputData['admin_classes_company']=session('now_company');
        if(DB::table("admin_classes")->where("admin_classes_ides","=",$inputData['admin_classes_ides'])->where("admin_classes_company","=",$inputData['admin_classes_company'])->first())
        {
            $baseFunc -> setRedirectMessage(false,"已有此科室管理员账号，请重新添加",NULL,"/secondAdmins");
        }
        else
        {
            DB::table("admin_classes")->insert($inputData);
            $baseFunc -> setRedirectMessage(true,"添加科室管理员成功",NULL,"/secondAdmins");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BaseFunc $baseFunc
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @internal param \Illuminate\Http\Request $request
     */
    public function update(BaseFunc $baseFunc, $id)
    {
        $inputData = Input::except("_token","_method");
        $data = Request::only('admin_classes_ids','admin_classes_company');
        if($inputData['admin_classes_job'] != "领用人")
        {
            $inputData['admin_classes_password']=md5(123456);
        }
        if(DB::table("admin_classes")->where("admin_classes_ides","=",$inputData['admin_classes_ides'])->where( "admin_classes_company","=",$data['admin_classes_company'])->first() && $id != $data['admin_classes_ids'])//输入的账号相同但是id不同
        {
            $baseFunc -> setRedirectMessage(false,"已有此人员账号，请重新修改",NULL,"/secondAdmins");
        }
        else
        {
            $re=DB::table("admin_classes")
                ->where("admin_classes_ids","=",$id)
                ->update($inputData);
            if($re)
            {
                $baseFunc -> setRedirectMessage(true,"修改科室管理员成功",NULL,"/secondAdmins");
            }
            else
            {
                $baseFunc -> setRedirectMessage(false,"您没有修改此科室管理员信息",NULL,"/secondAdmins");
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $re=DB::table('admin_classes')->where('admin_classes_ids',$id)->delete();
        if($re){
            $data=[
                'status'=>1,
                'message'=>'删除成功！'
            ];
        }else{
            $data=[
                'status'=>0,
                'message'=>'删除失败！'
            ];
        }
        return json_encode($data);
    }
		
	public function judgeId(){
		$input=Input::except("_token");
		if(!isset($input["sta"])){
			$re=DB::table('admin_classes')->where('admin_classes_ides',$input["ides"])->get();
			if($re){
			$data=[
			"status"=>1,
			"msg"=>"已有此人员编码，请重新输入！",
			];
		}else{
			$data=[
			"status"=>0,
			];
		}
		}else{
			$re=DB::table('admin_classes')->where('admin_classes_ides',$input["ides"])->where('admin_classes_id',$input["id"])->first();
			if($re){
				$data=[
			    "status"=>0,
			    ];
			}else{
				$re1=DB::table('admin_classes')->where('admin_classes_ides',$input["ides"])->get();
				if($re1){
					$data=[
			          "status"=>1,
			          "msg"=>"已有此人员编码，请重新输入！",
			          ];
				}else{
					$data=[
			          "status"=>0,
			          ];
				}
			}
		}
		
		
		return json_encode($data);
	}
}
