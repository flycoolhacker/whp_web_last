<?php

namespace App\Http\Controllers\AdminTop;

use App\Base\BaseFunc;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;

class AdminTopCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data["companyData"] = DB::table("company")->get();
        return view("/Home.AdminTops.company",$data);
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
        $inputData = Request::only('company_name','company_id');

        if(DB::table("company")->where("company_id","=",$inputData['company_id'])->first())
        {
            $baseFunc -> setRedirectMessage(false,"已有此单位编码，请重新添加",NULL,"/company");
        }
        else
        {
            DB::table("company")->insert($inputData);
            $baseFunc -> setRedirectMessage(true,"添加单位成功",NULL,"/company");
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
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @param BaseFunc $baseFunc
     * @return \Illuminate\Http\Response
     */
    public function update($id, BaseFunc $baseFunc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $company_id
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(BaseFunc $baseFunc,$company_id)
    {
        DB::table('admin_classes')->where('admin_classes_company',$company_id)->delete();
        DB::table('log')->where('log_company',$company_id)->delete();
        DB::table('classes')->where('classes_company',$company_id)->delete();
        DB::table('goods')->where('goods_company',$company_id)->delete();
        DB::table('admin_second')->where('admin_second_company',$company_id)->delete();
        $re= DB::table('company')->where('company_id',$company_id)->delete();
        if($re){
            DB::table('company')->where('company_id',$company_id)->delete();
            $baseFunc -> setRedirectMessage(true, "删除成功！", NULL, "/company" );
        }else{
            $baseFunc -> setRedirectMessage(false, "删除失败！", NULL, "/company" );
        }
    }
//$data=[
//'status'=>1,
//'message'=>'删除成功！'
//];
//$data=[
//'status'=>0,
//'message'=>'删除失败！'
//];return json_encode($data);
}
