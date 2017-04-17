<?php

namespace App\Http\Controllers\AdminTop;

use App\Base\BaseFunc;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;

class AdminTopAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data["adminData"] = DB::table("admin_second")->leftJoin("company","company_id","=","admin_second_company")->get();
        $data["companyData"] = DB::table("company")->get();
        return view("/Home.AdminTops.secondAdmin",$data);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BaseFunc $baseFunc)
    {

        $inputData = Request::only('admin_second_ids','admin_second_name','admin_second_company');
        $inputData['admin_second_password']=md5(123456);
        if(DB::table("admin_second")->where("admin_second_ids","=",$inputData['admin_second_ids'])->first())
        {
            $baseFunc -> setRedirectMessage(false,"已有此单位管理员，请重新添加",NULL,"/secondAdmin");
        }
        else
        {
            DB::table("admin_second")->insert($inputData);
            $baseFunc -> setRedirectMessage(true,"添加单位管理员成功",NULL,"/secondAdmin");
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $re=DB::table('admin_second')->where('admin_second_id',$id)->delete();
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
