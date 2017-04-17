<?php

namespace App\Http\Controllers\adminSecond;


use App\Base\BaseFunc;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("/Home.AdminSeconds.person");
    }

    public function searchPerson()
    {
        $userName = Input::only("person_name");
        $data["SexData"] = DB::table("sex")->get();
        $data["ClassesData"] = DB::table("classes")->where("classes_company",session("now_company"))->get();
        $data["ClassData"] = DB::table("person_class")->get();
        $data["JobData"] = DB::table("job")->get();
        $data["PersonData"] = DB::table("person")
            ->leftJoin("classes","classes_id","=","person_classes")
            ->where("person_company","=",session("now_company"))
            ->where("person_name","like","%".$userName["person_name"]."%")
            ->get();
        return view("/Home.AdminSeconds.person",$data);
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
        $input = Request::only('person_ids','person_name','person_sex','person_classes','person_class','person_phone','person_job','person_num','person_add');
        $input['person_company']=session('now_company');
        if(DB::table("person")->where("person_ids","=",$input['person_ids'])->where("person_company","=",$input['person_company'])->first())
        {
            $baseFunc -> setRedirectMessage(false,"已有此单位人员编码，请重新添加",NULL,"/person");
        }
        else
        {
            DB::table("person")->insert($input);
            $baseFunc -> setRedirectMessage(true,"添加单位人员成功",NULL,"/person");
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
    public function update(BaseFunc $baseFunc,$id)
    {
        $input = Request::only('person_ids','person_name','person_sex','person_classes','person_class','person_phone','person_job','person_num','person_add');
        $data = Request::only('person_id','person_company');
        if(DB::table("person")->where("person_ids","=",$input['person_ids'])->where( "person_company","=",$data['person_company'])->first() && $id != $data['person_id'])
        {
            $baseFunc -> setRedirectMessage(false,"已有此单位人员编码，请重新修改",NULL,"/person");
        }
        else
        {
            $re=DB::table("person")
                ->where("person_id","=",$id)
                ->update($input);
            if($re)
            {
                $baseFunc -> setRedirectMessage(true,"修改单位人员成功",NULL,"/person");
            }
            else
            {
                $baseFunc -> setRedirectMessage(false,"您没有修改此人信息",NULL,"/person");
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
        $re=DB::table('person')->where('person_id',$id)->delete();
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
		dd($input);
	}
}
