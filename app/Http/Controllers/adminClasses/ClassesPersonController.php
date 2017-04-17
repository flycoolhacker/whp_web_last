<?php

namespace App\Http\Controllers\adminClasses;

use App\Base\BaseFunc;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class ClassesPersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("/Home.AdminClasses.classesperson");
    }

    public function searchClassesPerson()
    {
        //dump(session("now_company"));
        $userName = Input::only("admin_classes_name");
        $data["SexData"] = DB::table("sex")->get();
        $data["ClassesData"] = DB::table("classes")->where("classes_company",session("now_company"))->get();
        $data["ClassData"] = DB::table("person_class")->get();
        $data["JobData"] = DB::table("job")->get();
        $data["PersonData"] = DB::table("admin_classes")
            ->leftJoin("classes","classes_id","=","admin_classes_classes")
            ->where("admin_classes_company","=",session("now_company"))
            ->where("admin_classes_classes","=",session("now_classes"))
            ->where("admin_classes_password",null)
            ->where("admin_classes_name","like","%".$userName["admin_classes_name"]."%")
            ->get();
        return view("/Home.AdminClasses.classesperson",$data);
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
        $input=Input::except("_token");
        $input['admin_classes_company']=session('now_company');
        $input['admin_classes_classes']=session("now_classes");
        if(DB::table("admin_classes")->where("admin_classes_ids","=",$input['admin_classes_ids'])->where("admin_classes_company","=",session("now_company"))->first())
        {
            $baseFunc -> setRedirectMessage(false,"已有此单位人员ID，请重新添加",NULL,"/classesperson");
        }
        else
        {
            DB::table("admin_classes")->insert($input);
            $baseFunc -> setRedirectMessage(true,"添加单位人员成功",NULL,"/classesperson");
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
        $input =Input::except("_token","_method");
        $data = Request::only('admin_classes_ids');
        if(DB::table("admin_classes")->where("admin_classes_ids","=",$input['admin_classes_ids'])->where( "admin_classes_company","=",session('now_company'))->first() && $id != $data['admin_classes_ids'])
        {
            $baseFunc -> setRedirectMessage(false,"已有此单位人员ID，请重新修改",NULL,"/classesperson");
        }
        else
        {
            $re=DB::table("admin_classes")
                ->where("admin_classes_ids","=",$id)
                ->update($input);
            if($re)
            {
                $baseFunc -> setRedirectMessage(true,"修改单位人员成功",NULL,"/classesperson");
            }
            else
            {
                $baseFunc -> setRedirectMessage(false,"您没有修改此人信息",NULL,"/classesperson");
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
}
