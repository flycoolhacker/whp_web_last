<?php

namespace App\Http\Controllers\adminClasses;

use App\Http\Model\Logmodel;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;;
use App\Http\Model\Goodsmodel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Base\BaseFunc;


class ClassesAdmin extends Controller
{ /**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
    public function index()
    {
        $Seek=null;
        $KSclass=Input::only('YP_type');
        $clsses=DB::table("classes")->where("classes_name",session("now_classes"))->where("classes_company",session("now_company"))->value("classes_id");
        if(!empty($KSclass["YP_type"])){
            if($KSclass["YP_type"]==0){
                $NormalData=DB::table("goods")->where("goods_classes",session("now_classes"))->where("goods_company","=",session("now_company"))->paginate(12);
            }else{
                $NormalData=DB::table("goods")->where("goods_classes",session("now_classes"))->where("goods_company","=",session("now_company"))->where("goods_info",$KSclass["YP_type"])->paginate(12);
            }
        }else{
            $NormalData=DB::table("goods")->where("goods_classes",session("now_classes"))->where("goods_company","=",session("now_company"))->paginate(12);
        }
        return view("Home.AdminClasses.goods",compact('NormalData','KSclass','Seek'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(BaseFunc $baseFunc)
    {
        $class=DB::table("goods_class")->get();
        $dangerous=DB::table("dangerous")->get();
        $store=DB::table("store")->get();
        $usefor=DB::table("usefor")->get();
        $units=DB::table("units")->get();
        $classes=session("now_classes");
        $account=DB::table("admin_classes")
            ->where("admin_classes_company",session("now_company"))
            ->where("admin_classes_classes",session("now_classes"))
            ->whereNotNull("admin_classes_password")
            ->where("admin_classes_job","=","管账管理员")->get();
        $mcmater=DB::table("admin_classes")
            ->where("admin_classes_company",session("now_company"))
            ->where("admin_classes_classes",session("now_classes"))
            ->whereNotNull("admin_classes_password")
            ->where("admin_classes_job","=","管物管理员")->get();
        $max_id=DB::select('SELECT goods_id from goods where goods_id = (SELECT max(goods_id) FROM goods);');
        $max_id=date('YmdHis').(mt_rand(10000,99999)/1);
        if($account&&$mcmater){
            return view("Home.AdminClasses.AddNormal",compact("units","account","mcmater","class","dangerous","store","usefor","max_id","classes"));
        }else{
            $baseFunc-> setRedirectMessage(false,"该科室没有物管或者帐管，请检查",NULL,"/classesadmin");
        }

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
            $log=[
              'log_time'=>date("Y-m-d H:i:s",strtotime('+8 hours')),
              'log_goods_units'=>$input['goods_units'],
              'log_goods_name'=>$input['goods_name'],
              'log_goods_all'=>$input['goods_all'],
              'log_goods_in'=>$input['goods_in'],
              'log_goods_out'=>$input['goods_out'],
              'log_goods_now'=>$input['goods_now'],
              'log_use_master'=>"无",
              'log_user'=>"无",
              'log_info'=>2,
              'log_company'=>session('now_company'),
              'log_classes'=>session("now_classes"),
                'log_add'=>"添加药品",
            ];
        }else{
            $rules=[
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
            $log=[
                'log_time'=>date("Y-m-d H:i:s",strtotime('+8 hours')),
                'log_goods_units'=>$input['goods_units'],
                'log_goods_name'=>$input['goods_name'],
                'log_goods_all'=>$input['goods_all'],
                'log_goods_in'=>$input['goods_in'],
                'log_goods_out'=>$input['goods_out'],
                'log_goods_now'=>$input['goods_now'],
                'log_use_master'=>"无",
                'log_user'=>"无",
                'log_account_master'=>$input['goods_account_master'],
                'log_mcmater_master'=>$input['goods_mcmater_master'],
                'log_info'=>1,
                'log_company'=>session('now_company'),
                'log_classes'=>session("now_classes"),
                'log_add'=>"添加药品",
            ];
        }

        $validator=Validator::make($input,$rules,$msg);
        if($validator->passes()){
            $input["goods_company"]=session("now_company");
            $input["goods_time"]=date("Y-m-d H:i:s",strtotime('+8 hours'));
            $input["goods_classes"]=session("now_classes");
            $re1=Logmodel::create($log);
            if($re1){
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
        $class=DB::table("goods_class")->get();
        $dangerous=DB::table("dangerous")->get();
        $store=DB::table("store")->get();
        $usefor=DB::table("usefor")->get();
        $units=DB::table("units")->get();
        $user=DB::table("admin_classes")->get();
        $account=DB::table("admin_classes")
            ->where("admin_classes_company",session("now_company"))
            ->where("admin_classes_classes",session("now_classes"))
            ->whereNotNull("admin_classes_password")
            ->where("admin_classes_job","=","管账管理员")->get();
        $mcmater=DB::table("admin_classes")
            ->where("admin_classes_company",session("now_company"))
            ->where("admin_classes_classes",session("now_classes"))
            ->whereNotNull("admin_classes_password")
            ->where("admin_classes_job","=","管物管理员")->get();
        return view("Home.AdminClasses.EditGoods",compact("goods","classes","units","user","class","dangerous","store","usefor","account","mcmater"));
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
        $rules=[
                'goods_now'=>'required',
            ];
            $msg=[
                'goods_now.required'=>'未输入药品现有量！',
            ];
        $log=[
            'log_time'=>date("Y-m-d H:i:s",strtotime('+8 hours')),
            'log_goods_units'=>$input['goods_units'],
            'log_goods_name'=>$input['goods_name'],
            'log_goods_all'=>$input['goods_now'],
            'log_goods_in'=>0,
            'log_goods_out'=>0,
            'log_goods_now'=>$input['goods_now'],
            'log_use_master'=>"无",
            'log_user'=>"无",
            'log_account_master'=>$input['goods_account_master'],
            'log_mcmater_master'=>$input['goods_mcmater_master'],
            'log_info'=>$input['goods_info'],
            'log_company'=>session('now_company'),
            'log_classes'=>session("now_classes"),
            'log_add'=>"盘点药品",
        ];

        $goods=DB::table('goods')->where('goods_ids',$id)->first();
        $account=DB::table("admin_classes")
            ->where("admin_classes_company",session("now_company"))
            ->where("admin_classes_classes",session("now_classes"))
            ->whereNotNull("admin_classes_password")
            ->where("admin_classes_job","=","管账管理员")->get();
        $mcmater=DB::table("admin_classes")
            ->where("admin_classes_company",session("now_company"))
            ->where("admin_classes_classes",session("now_classes"))
            ->whereNotNull("admin_classes_password")
            ->where("admin_classes_job","=","管物管理员")->get();
        $validator=Validator::make($input,$rules,$msg);
        if($validator->passes()){
            $re1=Logmodel::create($log);
            if($re1){
                $re=Goodsmodel::where('goods_ids',$id)->update($input);
                if($re){
                    $goods=DB::table('goods')->where('goods_ids',$id)->first();
                    return view("Home.AdminClasses.EditGoods",compact("goods","account","mcmater"))->withErrors('更新成功！');
                }else{
                    return view("Home.AdminClasses.EditGoods",compact("goods","account","mcmater"))->withErrors('您未更新！');
                }
            }else{
                return view("Home.AdminClasses.EditGoods",compact("goods","account","mcmater"))->withErrors('您未更新！');
            }

        }else{
            return view("Home.AdminClasses.EditGoods",compact("goods","account","mcmater"))->withErrors('请检查输入格式！');
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
        $re=DB::table('goods')->where('goods_ids',$id)->delete();
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
            return view('Home.AdminClasses.goods',compact('NormalData','ClassesData','KSclass','Seek'));
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
