<?php
namespace App\Http\Controllers\adminSecond;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

/**
 * Created by PhpStorm.
 * User: Silence
 * Date: 2016/9/4
 * Time: 16:05
 */
require_once "PHPExcle/PHPExcel/PHPExcel.php";
class ExcleController extends Controller
{
    public function show(){
        $input=Input::all();
        $TimeData=$input;
        if($input["classes"]==0){
            $TimeData["classes_name"]="全部科室";
            $goods_data=DB::table('goods')->where('goods_info',$input['YP_type'])
                ->where('goods_time', '>=', $input['starttime'])
                ->Where('goods_time', '<=', $input['stoptime'])
                ->where('goods_company',session("now_company"))
				->orderBy('goods_time','desc')
                ->paginate(10);			
				foreach($goods_data as $k=>$v){
			 $v->goods_in=DB::table('log')->where('log_company',session("now_company"))
                ->where('log_time', '>=', $input['starttime'])
                ->Where('log_time', '<=', $input['stoptime'])
                ->where('log_goods_name',$v->goods_name)
                ->sum("log_goods_in");
			$v->goods_out=DB::table('log')->where('log_company',session("now_company"))
                ->where('log_time', '>=', $input['starttime'])
                ->Where('log_time', '<=', $input['stoptime'])
                ->where('log_goods_name',$v->goods_name)
                ->sum("log_goods_out");
		}
        }else{
            $goods_data=DB::table('goods')->where('goods_info',$input['YP_type'])
                ->where('goods_classes',$input['classes'])
                ->where('goods_time', '>=', $input['starttime'])
                ->Where('goods_time', '<=', $input['stoptime'])
                ->where('goods_company',session("now_company"))
				->orderBy('goods_time','desc')
                ->paginate(10);
			foreach($goods_data as $k=>$v){
			 $v->goods_in=DB::table('log')->where('log_company',session("now_company"))
			    ->where('log_classes',$input['classes'])
                ->where('log_time', '>=', $input['starttime'])
                ->Where('log_time', '<=', $input['stoptime'])
                ->where('log_goods_name',$v->goods_name)
                ->sum("log_goods_in");
			$v->goods_out=DB::table('log')->where('log_company',session("now_company"))
		    	->where('log_classes',$input['classes'])
                ->where('log_time', '>=', $input['starttime'])
                ->Where('log_time', '<=', $input['stoptime'])
                ->where('log_goods_name',$v->goods_name)
                ->sum("log_goods_out");
	     	}
            $TimeData["classes_name"]=DB::table("classes")->where("classes_id",$input["classes"])->value("classes_name");
        }
		
      if($input['YP_type']==1){
            return view('Home.AdminSeconds/ListGoods',compact('goods_data','TimeData'));
        }else{
            return view('Home.AdminSeconds/NomalListGoods',compact('goods_data','TimeData'));
        }
		

    }
    public function OutExcle(){
        $input=Input::except('_token');
        if($input["classes"]==0){
            $TimeData["classes_name"]="全部科室";
            $goods_data=DB::table('goods')->where('goods_info',$input['YP_type'])
                ->where('goods_time', '>=', $input['starttime'])
                ->Where('goods_time', '<=', $input['stoptime'])
                ->where('goods_company',session("now_company"))
				->orderBy('goods_time','desc')
                ->get();
            $classes="全部科室";
        }else{
            $goods_data=DB::table('goods')->where('goods_info',$input['YP_type'])
                ->where('goods_classes',$input['classes'])
                ->where('goods_time', '>=', $input['starttime'])
                ->Where('goods_time', '<=', $input['stoptime'])
                ->where('goods_company',session("now_company"))
				->orderBy('goods_time','desc')
                ->get();
            $classes=DB::table("classes")->where("classes_id",$input["classes"])->value("classes_name");
        }
        $objPHPexcel=new \PHPExcel();
        $objSheet=$objPHPexcel->getActiveSheet();
        $objSheet->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//水平垂直居中
        $objSheet->getDefaultStyle()->getFont()->setName("宋体")->setSize(9);
        $objSheet->setTitle('危化品');
        $objSheet->setCellValue("A1","危险化学品消耗量汇总表");
        $objSheet->mergeCells("A1:S1");//合并单元格
        $objSheet->getStyle("A1:S1")->getFont()->setName("宋体")->setSize(26);//设置样式
        $objSheet->setCellValue("A2","科室：".$classes."                                                 导出时间：".$input['starttime']."——".$input['stoptime']);
        $objSheet->mergeCells("A2:S2");
        $objSheet->getStyle('A2:S2')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);//设置第二标题左对齐

        $objSheet->getStyle("A2:S2")->getFont()->setName("Time New Row")->setSize(14);
        $objSheet->setCellValue("A3","危险化\n学品名\n称")//换行
            ->setCellValue("B3","特性\n(分类)")
            ->setCellValue("C3","高危\n中危\n低危")
            ->setCellValue("D3","储存环\n境要求")
            ->setCellValue("E3","规格")
            ->setCellValue("F3","生产厂家")
            ->setCellValue("G3","购买途径")
            ->setCellValue("H3","用途")
            ->setCellValue("I3","存放位置")
            ->setCellValue("J3","储存容器")
            ->setCellValue("K3","危险化学\n品运输")
            ->setCellValue("L3","数量单位")
            ->setCellValue("M3","库存总量")
            ->setCellValue("N3","入库量")
            ->setCellValue("O3","出库(消\n耗)量")
            ->setCellValue("P3","现有量")
            ->setCellValue("Q3","记账管理\n(负责人)")
            ->setCellValue("R3","记物管理\n(责任人)")
            ->setCellValue("S3","操作时间");
        $objSheet->getStyle("A3")->getAlignment()->setWrapText(true);//自动换行
        $objSheet->getStyle("B3")->getAlignment()->setWrapText(true);
        $objSheet->getStyle("C3")->getAlignment()->setWrapText(true);
        $objSheet->getStyle("D3")->getAlignment()->setWrapText(true);
        $objSheet->getStyle("K3")->getAlignment()->setWrapText(true);
        $objSheet->getStyle("O3")->getAlignment()->setWrapText(true);
        $objSheet->getStyle("Q3")->getAlignment()->setWrapText(true);
        $objSheet->getStyle("R3")->getAlignment()->setWrapText(true);
		if($input["classes"]==0){
		foreach($goods_data as $kv=>$gv){
            $kv=$kv+4;
            $objSheet->setCellValue("A".$kv,"$gv->goods_name")
                ->setCellValue("B".$kv,"$gv->goods_class")
                ->setCellValue("C".$kv,"$gv->goods_dangerous")
                ->setCellValue("D".$kv,"$gv->goods_store")
                ->setCellValue("E".$kv,"$gv->goods_standard")
                ->setCellValue("F".$kv,"$gv->goods_facture")
                ->setCellValue("G".$kv,"$gv->goods_from")
                ->setCellValue("H".$kv,"$gv->goods_usefor")
                ->setCellValue("I".$kv,"$gv->goods_place")
                ->setCellValue("J".$kv,"$gv->goods_container")
                ->setCellValue("K".$kv,"$gv->goods_trans")
                ->setCellValue("L".$kv,"$gv->goods_units")
                ->setCellValue("M".$kv,"$gv->goods_all")
                ->setCellValue("N".$kv,DB::table('log')->where('log_company',session("now_company"))
                ->where('log_time', '>=', $input['starttime'])
                ->Where('log_time', '<=', $input['stoptime'])
                ->where('log_goods_name',"$gv->goods_name")
                ->sum("log_goods_in"))
                ->setCellValue("O".$kv,DB::table('log')->where('log_company',session("now_company"))
                ->where('log_time', '>=', $input['starttime'])
                ->Where('log_time', '<=', $input['stoptime'])
                ->where('log_goods_name',"$gv->goods_name")
                ->sum("log_goods_out"))
                ->setCellValue("P".$kv,"$gv->goods_now")
                ->setCellValue("Q".$kv,"$gv->goods_account_master")
                ->setCellValue("R".$kv,"$gv->goods_mcmater_master")
                ->setCellValue("S".$kv,"$gv->goods_time");
            $objSheet->getStyle("A".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("B".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("C".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("D".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("E".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("F".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("G".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("H".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("I".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("J".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("K".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("L".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("M".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("N".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("O".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("P".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("Q".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("R".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("S".$kv)->getAlignment()->setWrapText(true);
        }
		}else{
			foreach($goods_data as $kv=>$gv){
            $kv=$kv+4;
            $objSheet->setCellValue("A".$kv,"$gv->goods_name")
                ->setCellValue("B".$kv,"$gv->goods_class")
                ->setCellValue("C".$kv,"$gv->goods_dangerous")
                ->setCellValue("D".$kv,"$gv->goods_store")
                ->setCellValue("E".$kv,"$gv->goods_standard")
                ->setCellValue("F".$kv,"$gv->goods_facture")
                ->setCellValue("G".$kv,"$gv->goods_from")
                ->setCellValue("H".$kv,"$gv->goods_usefor")
                ->setCellValue("I".$kv,"$gv->goods_place")
                ->setCellValue("J".$kv,"$gv->goods_container")
                ->setCellValue("K".$kv,"$gv->goods_trans")
                ->setCellValue("L".$kv,"$gv->goods_units")
                ->setCellValue("M".$kv,"$gv->goods_all")
                ->setCellValue("N".$kv,DB::table('log')->where('log_company',session("now_company"))
				->where('log_classes',$input['classes'])
                ->where('log_time', '>=', $input['starttime'])
                ->Where('log_time', '<=', $input['stoptime'])
                ->where('log_goods_name',"$gv->goods_name")
                ->sum("log_goods_in"))
                ->setCellValue("O".$kv,DB::table('log')->where('log_company',session("now_company"))
				->where('log_classes',$input['classes'])
                ->where('log_time', '>=', $input['starttime'])
                ->Where('log_time', '<=', $input['stoptime'])
                ->where('log_goods_name',"$gv->goods_name")
                ->sum("log_goods_out"))
                ->setCellValue("P".$kv,"$gv->goods_now")
                ->setCellValue("Q".$kv,"$gv->goods_account_master")
                ->setCellValue("R".$kv,"$gv->goods_mcmater_master")
                ->setCellValue("S".$kv,"$gv->goods_time");
            $objSheet->getStyle("A".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("B".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("C".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("D".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("E".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("F".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("G".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("H".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("I".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("J".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("K".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("L".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("M".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("N".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("O".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("P".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("Q".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("R".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("S".$kv)->getAlignment()->setWrapText(true);
        }
		}
        function out_browser($type,$name){
            if($type=="excle5"){
                header('Content-Type: application/vnd.ms-excel');
                header("Content-Disposition: attachment;filename=$name.xls");//输出文件名称
            }else{
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header("Content-Disposition: attachment;filename=$name.xlsx");//输出文件名称
            }

            header('Cache-Control: max-age=0');//禁止缓存
        }
        out_browser("excle7",date("Y-m-d")."-WXHXPXHLHZ");
        $objWriter=\PHPExcel_IOFactory::createWriter($objPHPexcel,"Excel2007");
        $objWriter->save("php://output");
        // $objWriter->save("D:/Excle/public1.xlsx");   //保存文件
        //return redirect()->back()->withErrors('导出到Excel成功');
    }



    public function OutExcle1(){
        $input=Input::except('_token');
        if($input["classes"]==0){
            $TimeData["classes_name"]="全部科室";
            $goods_data=DB::table('goods')->where('goods_info',$input['YP_type'])
                ->where('goods_company',session("now_company"))
                ->get();
            $classes="全部科室";
        }else{
            $goods_data=DB::table('goods')->where('goods_info',$input['YP_type'])
                ->where('goods_classes',$input['classes'])
                ->where('goods_company',session("now_company"))
                ->get();
            $classes=DB::table("classes")->where("classes_id",$input["classes"])->value("classes_name");
        }
        $objPHPexcel=new \PHPExcel();
        $objSheet=$objPHPexcel->getActiveSheet();
        $objSheet->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//水平垂直居中
        $objSheet->getDefaultStyle()->getFont()->setName("宋体")->setSize(10);
        $objSheet->setTitle('危化品');
        $objSheet->setCellValue("A1","危险化学品库存表");
        $objSheet->mergeCells("A1:F1");//合并单元格
        $objSheet->getStyle("A1:F1")->getFont()->setName("宋体")->setSize(26);//设置样式
        $objSheet->setCellValue("A2","科室：".$classes."    导出时间：".date("Y-m-d h:i:s"));
        $objSheet->mergeCells("A2:F2");
        $objSheet->getStyle('A2:F2')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);//设置第二标题左对齐

        $objSheet->getStyle("A2:F2")->getFont()->setName("Time New Row")->setSize(14);
        $objSheet->setCellValue("A3","危险化\n学品名称")//换行
        ->setCellValue("B3","特性\n(分类)")
            ->setCellValue("C3","规格")
            ->setCellValue("D3","数量单位")
            ->setCellValue("E3","目前库\n存总量")
            ->setCellValue("F3","存放位置");
        $objSheet->getStyle("A3")->getAlignment()->setWrapText(true);
        $objSheet->getStyle("B3")->getAlignment()->setWrapText(true);
        $objSheet->getStyle("E3")->getAlignment()->setWrapText(true);
        foreach($goods_data as $kv=>$gv){
            $kv=$kv+4;
            $objSheet->setCellValue("A".$kv,"$gv->goods_name")
                ->setCellValue("B".$kv,"$gv->goods_class")
                ->setCellValue("C".$kv,"$gv->goods_standard")
                ->setCellValue("D".$kv,"$gv->goods_units")
                ->setCellValue("E".$kv,"$gv->goods_all")
                ->setCellValue("F".$kv,"$gv->goods_place");
            $objSheet->getStyle("A".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("B".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("C".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("D".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("E".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("F".$kv)->getAlignment()->setWrapText(true);
        }
        function out_browser($type,$name){
            if($type=="excle5"){
                header('Content-Type: application/vnd.ms-excel');
                header("Content-Disposition: attachment;filename=$name.xls");//输出文件名称
            }else{
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header("Content-Disposition: attachment;filename=$name.xlsx");//输出文件名称
            }

            header('Cache-Control: max-age=0');//禁止缓存
        }
        out_browser("excle7",date("Y-m-d")."-WXHXPKC");
        $objWriter=\PHPExcel_IOFactory::createWriter($objPHPexcel,"Excel2007");
        $objWriter->save("php://output");
        // $objWriter->save("D:/Excle/public1.xlsx");   //保存文件
        //return redirect()->back()->withErrors('导出到Excel成功');
    }

    public function NomalExcleShow(){
        $input=Input::except('_token');
        if($input["classes"]==0){
            $TimeData["classes_name"]="全部科室";
            $goods_data=DB::table('goods')->where('goods_info',$input['YP_type'])
                ->where('goods_time', '>=', $input['starttime'])
                ->Where('goods_time', '<=', $input['stoptime'])
                ->where('goods_company',session("now_company"))
				->orderBy('goods_time','desc')
                ->get();
            $classes="全部科室";
        }else{
            $goods_data=DB::table('goods')->where('goods_info',$input['YP_type'])
                ->where('goods_classes',$input['classes'])
                ->where('goods_time', '>=', $input['starttime'])
                ->Where('goods_time', '<=', $input['stoptime'])
                ->where('goods_company',session("now_company"))
				->orderBy('goods_time','desc')
                ->get();
            $classes=DB::table("classes")->where("classes_id",$input["classes"])->value("classes_name");
        }
        $objPHPexcel=new \PHPExcel();
        $objSheet=$objPHPexcel->getActiveSheet();
        $objSheet->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//水平垂直居中
        $objSheet->getDefaultStyle()->getFont()->setName("宋体")->setSize(9);
        $objSheet->setTitle('危化品');
        $objSheet->setCellValue("A1","试剂耗材消耗量汇总表");
        $objSheet->mergeCells("A1:I1");//合并单元格
        $objSheet->getStyle("A1:I1")->getFont()->setName("宋体")->setSize(26);//设置样式
        $objSheet->setCellValue("A2","科室：".$classes.     " 导出时间：".$input['starttime']."——".$input['stoptime']);
        $objSheet->mergeCells("A2:I2");
        $objSheet->getStyle('A2:I2')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);//设置第二标题左对齐

        $objSheet->getStyle("A2:S2")->getFont()->setName("Time New Row")->setSize(14);
        $objSheet->setCellValue("A3","名称")//换行
        ->setCellValue("B3","规格")
            ->setCellValue("C3","存放位置")
            ->setCellValue("D3","数量单位")
            ->setCellValue("E3","库存总量")
            ->setCellValue("F3","入库量")
            ->setCellValue("G3","出库(消\n耗)量")
            ->setCellValue("H3","现有量")
            ->setCellValue("I3","操作时间");
        $objSheet->getStyle("G3")->getAlignment()->setWrapText(true);//自动换行
		if($input["classes"]==0){
		foreach($goods_data as $kv=>$gv){
            $kv=$kv+4;
            $objSheet->setCellValue("A".$kv,"$gv->goods_name")
                ->setCellValue("B".$kv,"$gv->goods_standard")
                ->setCellValue("C".$kv,"$gv->goods_place")
                ->setCellValue("D".$kv,"$gv->goods_units")
                ->setCellValue("E".$kv,"$gv->goods_all")
                ->setCellValue("F".$kv,DB::table('log')->where('log_company',session("now_company"))
                ->where('log_time', '>=', $input['starttime'])
                ->Where('log_time', '<=', $input['stoptime'])
                ->where('log_goods_name',"$gv->goods_name")
                ->sum("log_goods_in"))
                ->setCellValue("G".$kv,DB::table('log')->where('log_company',session("now_company"))
                ->where('log_time', '>=', $input['starttime'])
                ->Where('log_time', '<=', $input['stoptime'])
                ->where('log_goods_name',"$gv->goods_name")
                ->sum("log_goods_out"))
                ->setCellValue("H".$kv,"$gv->goods_now")
                ->setCellValue("I".$kv,"$gv->goods_time");
            $objSheet->getStyle("A".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("B".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("C".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("D".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("E".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("F".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("G".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("H".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("I".$kv)->getAlignment()->setWrapText(true);
        }
		}else{
			foreach($goods_data as $kv=>$gv){
            $kv=$kv+4;
            $objSheet->setCellValue("A".$kv,"$gv->goods_name")
                ->setCellValue("B".$kv,"$gv->goods_standard")
                ->setCellValue("C".$kv,"$gv->goods_place")
                ->setCellValue("D".$kv,"$gv->goods_units")
                ->setCellValue("E".$kv,"$gv->goods_all")
                ->setCellValue("F".$kv,DB::table('log')->where('log_company',session("now_company"))
				->where('goods_classes',$input['classes'])
                ->where('log_time', '>=', $input['starttime'])
                ->Where('log_time', '<=', $input['stoptime'])
                ->where('log_goods_name',"$gv->goods_name")
                ->sum("log_goods_in"))
                ->setCellValue("G".$kv,DB::table('log')->where('log_company',session("now_company"))
				->where('goods_classes',$input['classes'])
                ->where('log_time', '>=', $input['starttime'])
                ->Where('log_time', '<=', $input['stoptime'])
                ->where('log_goods_name',"$gv->goods_name")
                ->sum("log_goods_out"))
                ->setCellValue("H".$kv,"$gv->goods_now")
                ->setCellValue("I".$kv,"$gv->goods_time");
            $objSheet->getStyle("A".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("B".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("C".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("D".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("E".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("F".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("G".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("H".$kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("I".$kv)->getAlignment()->setWrapText(true);
        }
		}
        function out_browser($type,$name){
            if($type=="excle5"){
                header('Content-Type: application/vnd.ms-excel');
                header("Content-Disposition: attachment;filename=$name.xls");//输出文件名称
            }else{
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header("Content-Disposition: attachment;filename=$name.xlsx");//输出文件名称
            }
            header('Cache-Control: max-age=0');//禁止缓存
        }
        out_browser("excle7",date("Y-m-d")."-SJHCXHLHZ");
        $objWriter=\PHPExcel_IOFactory::createWriter($objPHPexcel,"Excel2007");
        $objWriter->save("php://output");
    }

    public function NomalExcleShow1(){
        $input=Input::except('_token');
        if($input["classes"]==0){
            $TimeData["classes_name"]="全部科室";
            $goods_data=DB::table('goods')->where('goods_info',$input['YP_type'])
                ->where('goods_company',session("now_company"))
                ->get();
            $classes="全部科室";
        }else{
            $goods_data=DB::table('goods')->where('goods_info',$input['YP_type'])
                ->where('goods_classes',$input['classes'])
                ->where('goods_company',session("now_company"))
                ->get();
            $classes=DB::table("classes")->where("classes_id",$input["classes"])->value("classes_name");
        }
        $objPHPexcel = new \PHPExcel();
        $objSheet = $objPHPexcel->getActiveSheet();
        $objSheet->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//水平垂直居中
        $objSheet->getDefaultStyle()->getFont()->setName("宋体")->setSize(9);
        $objSheet->setTitle('危化品');
        $objSheet->setCellValue("A1", "试剂耗材库存表");
        $objSheet->mergeCells("A1:E1");//合并单元格
        $objSheet->getStyle("A1:E1")->getFont()->setName("宋体")->setSize(26);//设置样式
        $objSheet->setCellValue("A2", "科室：" . $classes .    " 导出时间：" . date("Y-m-d h:i:s"));
        $objSheet->mergeCells("A2:E2");
        $objSheet->getStyle('A2:E2')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);//设置第二标题左对齐

        $objSheet->getStyle("A2:E2")->getFont()->setName("Time New Row")->setSize(14);
        $objSheet->setCellValue("A3", "名称")//换行
        ->setCellValue("B3", "规格")
            ->setCellValue("C3", "存放位置")
            ->setCellValue("D3", "数量单位")
            ->setCellValue("E3", "库存总量");
        foreach ($goods_data as $kv => $gv) {
            $kv = $kv + 4;
            $objSheet->setCellValue("A" . $kv, "$gv->goods_name")
                ->setCellValue("B" . $kv, "$gv->goods_standard")
                ->setCellValue("C" . $kv, "$gv->goods_place")
                ->setCellValue("D" . $kv, "$gv->goods_units")
                ->setCellValue("E" . $kv, "$gv->goods_all");
            $objSheet->getStyle("A" . $kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("B" . $kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("C" . $kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("D" . $kv)->getAlignment()->setWrapText(true);
            $objSheet->getStyle("E" . $kv)->getAlignment()->setWrapText(true);
            function out_browser($type, $name)
            {
                if ($type == "excle5") {
                    header('Content-Type: application/vnd.ms-excel');
                    header("Content-Disposition: attachment;filename=$name.xls");//输出文件名称
                } else {
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header("Content-Disposition: attachment;filename=$name.xlsx");//输出文件名称
                }
                header('Cache-Control: max-age=0');//禁止缓存
            }

            out_browser("excle7", date("Y-m-d") . "-SJHCKC");
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPexcel, "Excel2007");
            $objWriter->save("php://output");
        }
    }
}

