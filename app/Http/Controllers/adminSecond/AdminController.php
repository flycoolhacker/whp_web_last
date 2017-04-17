<?php

namespace App\Http\Controllers\adminSecond;

use App\Http\Controllers\Controller;
use App\Http\Model\Goodsmodel;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Seek=null;
        $KSclass=Input::only('KS_select','YP_type');
        if(!empty($KSclass["KS_select"])||!empty($KSclass["YP_type"])){
            if(!empty($KSclass["KS_select"])&&!empty($KSclass["YP_type"])){
                $ClassesData=DB::table("classes")->where("classes_company","=",session("now_company"))->get();
                $NormalData=DB::table("goods")->where("goods_company","=",session("now_company"))->where("goods_classes",$KSclass["KS_select"])->where("goods_info",$KSclass["YP_type"])->paginate(12);
            }else if($KSclass["YP_type"]==1||$KSclass["YP_type"]==2){
                $ClassesData=DB::table("classes")->where("classes_company","=",session("now_company"))->get();
                $NormalData=DB::table("goods")->where("goods_company","=",session("now_company"))->where("goods_info",$KSclass["YP_type"])->paginate(12);
            }else{
            $ClassesData=DB::table("classes")->where("classes_company","=",session("now_company"))->get();
            $NormalData=DB::table("goods")->where("goods_company","=",session("now_company"))->where("goods_classes",$KSclass["KS_select"])->paginate(12);
            }
        }else{
            $ClassesData=DB::table("classes")->where("classes_company","=",session("now_company"))->get();
            $NormalData=DB::table("goods")->where("goods_company","=",session("now_company"))->paginate(12);
        }
        return view("Home.AdminSeconds.goods",compact('ClassesData','NormalData','KSclass','Seek'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes=DB::table("classes")->where("classes_company","=",session("now_company"))->get();
        $class=DB::table("goods_class")->get();
        $dangerous=DB::table("dangerous")->get();
        $store=DB::table("store")->get();
        $usefor=DB::table("usefor")->get();
        $units=DB::table("units")->get();
        $user=DB::table("admin_classes")->where("admin_classes_company","=",session("now_company"))->get();

        return view("Home.AdminSeconds.AddNormal",compact("classes","units","user","class","dangerous","store","usefor"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input=Input::except("_token");
        if($input['goods_info']==2){
            $rules=[
                'goods_classes'=>'required',
                'goods_name'=>'required',
                'goods_standard'=>'required',
                'goods_units'=>'required',
                'goods_place'=>'required',
                'goods_account_master'=>'required',
                'goods_mcmater_master'=>'required',
                'goods_all'=>'required',
                'goods_in'=>'required',
                'goods_out'=>'required',
                'goods_now'=>'required',
            ];
            $msg=[
                'goods_classes.required'=>'未添加科室!',
                'goods_name.required'=>'未输入药瓶名',
                'goods_standard.required'=>'未输入药品规格',
                'goods_units.required'=>'未输入药品单位！',
                'goods_place.required'=>'未输入药品存放位置',
                'goods_account_master.required'=>'未输入物品管理员！',
                'goods_mcmater_master.required'=>'未输入财务管理员！',
                'goods_all.required'=>'未输入药品总量！',
                'goods_in.required'=>'未输入药品入库量！',
                'goods_out.required'=>'未输入药品出库量！',
                'goods_now.required'=>'未输入药品现有量！',
            ];
        }else{
            $rules=[
                'goods_classes'=>'required',
                'goods_name'=>'required',
                'goods_standard'=>'required',
                'goods_units'=>'required',
                'goods_place'=>'required',
                'goods_account_master'=>'required',
                'goods_mcmater_master'=>'required',
                'goods_all'=>'required',
                'goods_in'=>'required',
                'goods_out'=>'required',
                'goods_now'=>'required',
                'goods_dangerous'=>'required',
                'goods_store'=>'required',
                'goods_class'=>'required',
                'goods_container'=>'required',
                'goods_usefor'=>'required',
                'goods_facture'=>'required',
                'goods_from'=>'required',
            ];
            $msg=[
                'goods_classes.required'=>'未添加科室!',
                'goods_name.required'=>'未输入药瓶名',
                'goods_standard.required'=>'未输入药品规格',
                'goods_units.required'=>'未输入药品单位！',
                'goods_place.required'=>'未输入药品存放位置',
                'goods_account_master.required'=>'未输入物品管理员！',
                'goods_mcmater_master.required'=>'未输入财务管理员！',
                'goods_all.required'=>'未输入药品总量！',
                'goods_in.required'=>'未输入药品入库量！',
                'goods_out.required'=>'未输入药品出库量！',
                'goods_now.required'=>'未输入药品现有量！',
                'goods_dangerous.required'=>'未选择危险等级',
                'goods_store.required'=>'未选择储存环境',
                'goods_class.required'=>'未选择特性分类',
                'goods_container.required'=>'未填写容器',
                'goods_usefor.required'=>'未选择用途',
                'goods_facture.required'=>'未填写购买途径',
                'goods_from.required'=>'未填写运输方向',
            ];
        }

        $validator=Validator::make($input,$rules,$msg);
        if($validator->passes()){
            $input["goods_company"]=session("now_company");
            $input["goods_time"]=date("Y-m-d H:i:s");
            $re=Goodsmodel::create($input);
            if($re){
                $data=[
                    'status'=>1,
                    'msg'=>'添加成功。',
                ];
            }else{
                $data=[
                    'status'=>0,
                    'msg'=>'插入数据失败,请检查输入！',
                ];
            }
        }else{
            $data=[
                'status'=>0,
                'msg'=>'添加失败,请检查输入！',
            ];
        }
        return json_encode($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $goods=DB::table('goods')->where('goods_id',$id)->where("goods_company","=",session("now_company"))->first();
        $classes=DB::table("classes")->where("classes_company","=",session("now_company"))->get();
        $class=DB::table("goods_class")->get();
        $dangerous=DB::table("dangerous")->get();
        $store=DB::table("store")->get();
        $usefor=DB::table("usefor")->get();
        $units=DB::table("units")->get();
        $user=DB::table("admin_classes")->get();
        return view("Home.AdminSeconds.EditGoods",compact("goods","classes","units","user","class","dangerous","store","usefor"));
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
        $input=Input::except('_token','_method');
        if($input['goods_info']==2){
            $rules=[
                'goods_classes'=>'required',
                'goods_name'=>'required',
                'goods_standard'=>'required',
                'goods_units'=>'required',
                'goods_place'=>'required',
                'goods_account_master'=>'required',
                'goods_mcmater_master'=>'required',
                'goods_all'=>'required',
                'goods_in'=>'required',
                'goods_out'=>'required',
                'goods_now'=>'required',
            ];
            $msg=[
                'goods_classes.required'=>'未添加科室!',
                'goods_name.required'=>'未输入药瓶名',
                'goods_standard.required'=>'未输入药品规格',
                'goods_units.required'=>'未输入药品单位！',
                'goods_place.required'=>'未输入药品存放位置',
                'goods_account_master.required'=>'未输入物品管理员！',
                'goods_mcmater_master.required'=>'未输入财务管理员！',
                'goods_all.required'=>'未输入药品总量！',
                'goods_in.required'=>'未输入药品入库量！',
                'goods_out.required'=>'未输入药品出库量！',
                'goods_now.required'=>'未输入药品现有量！',
            ];
        }else{
            $rules=[
                'goods_classes'=>'required',
                'goods_name'=>'required',
                'goods_standard'=>'required',
                'goods_units'=>'required',
                'goods_place'=>'required',
                'goods_account_master'=>'required',
                'goods_mcmater_master'=>'required',
                'goods_all'=>'required',
                'goods_in'=>'required',
                'goods_out'=>'required',
                'goods_now'=>'required',

                'goods_dangerous'=>'required',
                'goods_store'=>'required',
                'goods_class'=>'required',
                'goods_container'=>'required',
                'goods_usefor'=>'required',
                'goods_facture'=>'required',
                'goods_from'=>'required',
                'goods_trans'=>'required',
            ];
            $msg=[
                'goods_classes.required'=>'未添加科室!',
                'goods_name.required'=>'未输入药瓶名',
                'goods_standard.required'=>'未输入药品规格',
                'goods_units.required'=>'未输入药品单位！',
                'goods_place.required'=>'未输入药品存放位置',
                'goods_account_master.required'=>'未输入物品管理员！',
                'goods_mcmater_master.required'=>'未输入财务管理员！',
                'goods_all.required'=>'未输入药品总量！',
                'goods_in.required'=>'未输入药品入库量！',
                'goods_out.required'=>'未输入药品出库量！',
                'goods_now.required'=>'未输入药品现有量！',

                'goods_dangerous.required'=>'未选择危险等级',
                'goods_store.required'=>'未选择储存环境',
                'goods_class.required'=>'未选择特性分类',
                'goods_container.required'=>'未填写容器',
                'goods_usefor.required'=>'未选择用途',
                'goods_facture.required'=>'未填写购买途径',
                'goods_from.required'=>'未填写生产厂家',
                'goods_trans.required'=>'未填写运输方向',
            ];
        }
        $goods=DB::table('goods')->where('goods_id',$id)->first();
        $classes=DB::table("classes")->where("classes_company","=",session("now_company"))->get();
        $class=DB::table("goods_class")->get();
        $dangerous=DB::table("dangerous")->get();
        $store=DB::table("store")->get();
        $usefor=DB::table("usefor")->get();
        $units=DB::table("units")->get();
        $user=DB::table("admin_classes")->get();
        $validator=Validator::make($input,$rules,$msg);
        if($validator->passes()){
            $re=Goodsmodel::where('goods_id',$id)->update($input);
            if($re){
                $goods=DB::table('goods')->where('goods_id',$id)->first();
                $classes=DB::table("classes")->get();
                $class=DB::table("goods_class")->get();
                $dangerous=DB::table("dangerous")->get();
                $store=DB::table("store")->get();
                $usefor=DB::table("usefor")->get();
                $units=DB::table("units")->get();
                $user=DB::table("admin_classes")->get();
                $validator=Validator::make($input,$rules,$msg);
                return view("Home.AdminSeconds.EditGoods",compact("goods","classes","units","user","class","dangerous","store","usefor"))->withErrors('更新成功！');
            }else{
                return view("Home.AdminSeconds.EditGoods",compact("goods","classes","units","user","class","dangerous","store","usefor"))->withErrors('您未更新！');
            }
        }else{
            return view("Home.AdminSeconds.EditGoods",compact("goods","classes","units","user","class","dangerous","store","usefor"))->withErrors('请检查输入格式！');
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
        $re=DB::table('goods')->where('goods_id',$id)->delete();
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

    public function SeekName(){
        $input=Input::only('SeekName');
        $Seek=$input['SeekName'];
        $NormalData=DB::table('goods')->where("goods_company",session("now_company"))->where('goods_name','like',"%$Seek%")->paginate(12);
        $KSclass=null;
        if($NormalData){
            $ClassesData=DB::table("classes")->where("classes_company","=",session("now_company"))->get();
            return view('Home.AdminSeconds.goods',compact('NormalData','ClassesData','KSclass','Seek'));
        }else{
            return back()->withErrors('没有您要搜索的物品');
        }
    }


//    批量删除
    public function DeleteAll(){
        $input=Input::except("_token");
        $id=explode(",",$input['idAll']);
        for($i=0;$i<$input['length'];$i++){
            $re=DB::table('goods')->where('goods_id',$id[$i])->delete();
        }
        if($re){
            $data=[
                'status'=>1,
                'msg'=>'删除成功！',
            ];
        }else{
            $data=[
                'status'=>0,
                'msg'=>'删除失败！',
            ];
        }
        return json_encode($data);
    }
}
