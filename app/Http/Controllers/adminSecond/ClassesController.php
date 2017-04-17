<?php

namespace App\Http\Controllers\adminSecond;

use App\Base\BaseFunc;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['classesData'] = DB::table('classes')
            ->where('classes_company','=',session('now_company'))
            ->get();
        return view("/Home.AdminSeconds.classes",$data);
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
        $inputData = Request::only('classes_name');
        $inputData['classes_company'] = session('now_company');
        if(DB::table("classes")->where("classes_name","=",$inputData['classes_name'])->where("classes_company","=",$inputData['classes_company'])->first())
        {
            $baseFunc -> setRedirectMessage(false,"已有此科室，请重新添加",NULL,"/classes");
        }
        else
        {
            DB::table("classes")->insert($inputData);
            $baseFunc -> setRedirectMessage(true,"添加科室管理员成功",NULL,"/classes");
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
        $inputData = Request::only('classes_name');
        $classes_id=Input::only('classes_id');
        $data = Request::only('classes_id','classes_company');
        if(DB::table("classes")->where("classes_name","=",$inputData['classes_name'])->where("classes_company","=",$data['classes_company'])->first() && $id != $data['classes_id'])
        {
            $baseFunc -> setRedirectMessage(false,"已有此科室，请重新修改",NULL,"/classes");
        }
        else
        {
            $re=DB::table("classes")
                ->where("classes_id","=",$id)
                ->update($inputData);
            if($re)
            {
                $baseFunc -> setRedirectMessage(true,"修改科室管理员成功",NULL,"/classes");
            }
            else
            {
                $baseFunc -> setRedirectMessage(false,"您没有修改此科室管理员信息",NULL,"/classes");
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
        $res=DB::table('admin_classes')->where("admin_classes_company",session("now_company"))->where("admin_classes_classes",$id)->delete();
        $re=DB::table('classes')->where("classes_company",session("now_company"))->where('classes_id',$id)->delete();
        $re1=DB::table('goods')->where("goods_company",session("now_company"))->where('goods_classes',$id)->delete();
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
