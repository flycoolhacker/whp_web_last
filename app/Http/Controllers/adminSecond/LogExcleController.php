<?php

namespace App\Http\Controllers\adminSecond;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

require_once "PHPExcle/PHPExcel/PHPExcel.php";
class LogExcleController extends Controller
{
     public function show(){
          $input=Input::all();
          $TimeData=$input;
          if($input['id_classes']==0){
              if($input['desc']=="时间"){
                  $logs_data=DB::table('log')->where('log_company',session('now_company'))
                      ->where('log_time', '>=', $input['starttime'])
                      ->Where('log_time', '<=', $input['stoptime'])
                      ->where('log_info',$input['YP_type'])
                      ->orderBy('log_time', 'desc')
                      ->paginate(12);
              }else {
                  $logs_data = DB::table('log')->where('log_company', session('now_company'))
                      ->where('log_time', '>=', $input['starttime'])
                      ->Where('log_time', '<=', $input['stoptime'])
                      ->where('log_info', $input['YP_type'])
                      ->orderBy('log_goods_name', 'asc')
                      ->paginate(12);
              }
              $TimeData['classes_name']="所有科室";
          }else{
              if($input['desc']=="时间"){
                  $logs_data=DB::table('log')->where('log_company',session('now_company'))
                      ->leftJoin("classes","classes_id","=","log_classes")
                      ->where('log_classes',$input['id_classes'])
                      ->where('log_time', '>=', $input['starttime'])
                      ->Where('log_time', '<=', $input['stoptime'])
                      ->where('log_info',$input['YP_type'])
                      ->orderBy('log_time', 'desc')
                      ->paginate(12);
              }else{
                  $logs_data=DB::table('log')->where('log_company',session('now_company'))
                      ->leftJoin("classes","classes_id","=","log_classes")
                      ->where('log_classes',$input['id_classes'])
                      ->where('log_time', '>=', $input['starttime'])
                      ->Where('log_time', '<=', $input['stoptime'])
                      ->where('log_info',$input['YP_type'])
                      ->orderBy('log_goods_name', 'asc')
                      ->paginate(12);
              }
              $TimeData["classes_name"]=DB::table("classes")->where("classes_id",$TimeData["id_classes"])->value("classes_name");
          }
          if($input['YP_type']==1){
               return view("Home.AdminSeconds.ListLog",compact('logs_data','TimeData'));
          }else{
               return view("Home.AdminSeconds.NomalListLog",compact('logs_data','TimeData'));
          }
     }

    public function OutExcle(){
        $input=Input::except('_token');
        if($input['id_classes']==0){
            if($input['desc']=="时间"){
                $logs_data=DB::table('log')->where('log_company',session('now_company'))
                    ->where('log_time', '>=', $input['starttime'])
                    ->Where('log_time', '<=', $input['stoptime'])
                    ->where('log_info',$input['YP_type'])
                    ->orderBy('log_time', 'desc')
                    ->get();
            }else{
                $logs_data=DB::table('log')->where('log_company',session('now_company'))
                    ->where('log_time', '>=', $input['starttime'])
                    ->Where('log_time', '<=', $input['stoptime'])
                    ->where('log_info',1)
                    ->orderBy('log_goods_name', 'asc')
                    ->get();
            }
            $classes="所有科室";
        }else{
            if($input['desc']=="时间"){
                $logs_data=DB::table('log')->where('log_company',session('now_company'))
                    ->where('log_classes',$input['id_classes'])
                    ->where('log_time', '>=', $input['starttime'])
                    ->Where('log_time', '<=', $input['stoptime'])
                    ->where('log_info',$input['YP_type'])
                    ->orderBy('log_time', 'desc')
                    ->get();
            }else{
                $logs_data=DB::table('log')->where('log_company',session('now_company'))
                    ->where('log_classes',$input['id_classes'])
                    ->where('log_time', '>=', $input['starttime'])
                    ->Where('log_time', '<=', $input['stoptime'])
                    ->where('log_info',1)
                    ->orderBy('log_goods_name', 'asc')
                    ->get();
            }
            $classes=DB::table("classes")->where("classes_id",$input['id_classes'])->where("classes_company",session("now_company"))->value("classes_name");
        }
        $objPHPexcel=new \PHPExcel();
        $objSheet=$objPHPexcel->getActiveSheet();
        $objSheet->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//水平垂直居中
        $objSheet->getDefaultStyle()->getFont()->setName("宋体")->setSize(9);
        $objSheet->setTitle('危化品');
        $objSheet->setCellValue("A1","危险化学品出入库记录表");
        $objSheet->mergeCells("A1:L1");//合并单元格
        $objSheet->getStyle("A1:L1")->getFont()->setName("宋体")->setSize(26);//设置样式
        $objSheet->setCellValue("A2","科室：".$classes."           导出时间：".$input['starttime']."——".$input['stoptime']);
        $objSheet->mergeCells("A2:L2");
        $objSheet->getStyle('A2:L2')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);//设置第二标题左对齐

        $objSheet->getStyle("A2:L2")->getFont()->setName("Time New Row")->setSize(14);
        $objSheet->setCellValue("A3","时间")//换行
        ->setCellValue("B3","危险化学品\n名称")
            ->setCellValue("C3","数量单位")
            ->setCellValue("D3","库存总量")
            ->setCellValue("E3","入库量")
            ->setCellValue("F3","出库(消耗)量")
            ->setCellValue("G3","现有量")
            ->setCellValue("H3","记账管理\n(负责人)")
            ->setCellValue("I3","记物管理\n(责任人)")
            ->setCellValue("J3","领用人")
            ->setCellValue("K3","使用监督人")
            ->setCellValue("L3","备注");
        $objSheet->getStyle("B3")->getAlignment()->setWrapText(true);//自动换行
        $objSheet->getStyle("H3")->getAlignment()->setWrapText(true);
        $objSheet->getStyle("I3")->getAlignment()->setWrapText(true);
        foreach($logs_data as $kv=>$gv){
            $kv=$kv+4;
            $objSheet->setCellValue("A".$kv,"$gv->log_time")
                ->setCellValue("B".$kv,"$gv->log_goods_name")
                ->setCellValue("C".$kv,"$gv->log_goods_units")
                ->setCellValue("D".$kv,"$gv->log_goods_all")
                ->setCellValue("E".$kv,"$gv->log_goods_in")
                ->setCellValue("F".$kv,"$gv->log_goods_out")
                ->setCellValue("G".$kv,"$gv->log_goods_now")
                ->setCellValue("H".$kv,"$gv->log_mcmater_master")
                ->setCellValue("I".$kv,"$gv->log_account_master")
                ->setCellValue("J".$kv,"$gv->log_user")
                ->setCellValue("K".$kv,"$gv->log_use_master")
                ->setCellValue("L".$kv,"$gv->log_add");
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
        out_browser("excle7",date("Y-m-d")."-WHPCRKJL");
        $objWriter=\PHPExcel_IOFactory::createWriter($objPHPexcel,"Excel2007");
        $objWriter->save("php://output");
        // $objWriter->save("D:/Excle/public1.xlsx");   //保存文件
        //return redirect()->back()->withErrors('导出到Excel成功');
    }

    public function NomalExcleShow(){
        $input=Input::except('_token');
        if($input['id_classes']==0){
            if($input['desc']=="时间"){
                $logs_data=DB::table('log')->where('log_company',session('now_company'))
                    ->where('log_time', '>=', $input['starttime'])
                    ->Where('log_time', '<=', $input['stoptime'])
                    ->where('log_info',$input['YP_type'])
                    ->orderBy('log_time', 'desc')
                    ->get();
            }else{
                $logs_data=DB::table('log')->where('log_company',session('now_company'))
                    ->where('log_time', '>=', $input['starttime'])
                    ->Where('log_time', '<=', $input['stoptime'])
                    ->where('log_info',1)
                    ->orderBy('log_goods_name', 'asc')
                    ->get();
            }
            $classes="所有科室";
        }else{
            if($input['desc']=="时间"){
                $logs_data=DB::table('log')->where('log_company',session('now_company'))
                    ->where('log_classes',$input['id_classes'])
                    ->where('log_time', '>=', $input['starttime'])
                    ->Where('log_time', '<=', $input['stoptime'])
                    ->where('log_info',$input['YP_type'])
                    ->orderBy('log_time', 'desc')
                    ->get();
            }else{
                $logs_data=DB::table('log')->where('log_company',session('now_company'))
                    ->where('log_classes',$input['id_classes'])
                    ->where('log_time', '>=', $input['starttime'])
                    ->Where('log_time', '<=', $input['stoptime'])
                    ->where('log_info',2)
                    ->orderBy('log_goods_name', 'asc')
                    ->get();
            }
            $classes=DB::table("classes")->where("classes_id",$input['id_classes'])->where("classes_company",session("now_company"))->value("classes_name");
        }

        $objPHPexcel=new \PHPExcel();
        $objSheet=$objPHPexcel->getActiveSheet();
        $objSheet->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//水平垂直居中
        $objSheet->getDefaultStyle()->getFont()->setName("宋体")->setSize(9);
        $objSheet->setTitle('危化品');
        $objSheet->setCellValue("A1","常规试剂耗材出入库记录表");
        $objSheet->mergeCells("A1:J1");//合并单元格
        $objSheet->getStyle("A1:J1")->getFont()->setName("宋体")->setSize(26);//设置样式
        $objSheet->setCellValue("A2","科室：".$classes."           导出时间：".$input['starttime']."——".$input['stoptime']);
        $objSheet->mergeCells("A2:J2");
        $objSheet->getStyle('A2:J2')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);//设置第二标题左对齐

        $objSheet->getStyle("A2:J2")->getFont()->setName("Time New Row")->setSize(14);
        $objSheet->setCellValue("A3","时间")//换行
        ->setCellValue("B3","名称")
            ->setCellValue("C3","数量单位")
            ->setCellValue("D3","库存总量")
            ->setCellValue("E3","入库量")
            ->setCellValue("F3","出库(消\n耗)量")
            ->setCellValue("G3","现有量")
            ->setCellValue("H3","领用人")
            ->setCellValue("I3","管理人员")
            ->setCellValue("J3","备注");
        $objSheet->getStyle("F3")->getAlignment()->setWrapText(true);//自动换行
        foreach($logs_data as $kv=>$gv){
            $kv=$kv+4;
            $objSheet->setCellValue("A".$kv,"$gv->log_time")
                ->setCellValue("B".$kv,"$gv->log_goods_name")
                ->setCellValue("C".$kv,"$gv->log_goods_units")
                ->setCellValue("D".$kv,"$gv->log_goods_all")
                ->setCellValue("E".$kv,"$gv->log_goods_in")
                ->setCellValue("F".$kv,"$gv->log_goods_out")
                ->setCellValue("G".$kv,"$gv->log_goods_now")
                ->setCellValue("H".$kv,"$gv->log_user")
                ->setCellValue("I".$kv,"$gv->log_use_master")
                ->setCellValue("J".$kv,"$gv->log_add");
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
        out_browser("excle7",date("Y-m-d")."-CGSJHCCRKJL");
        $objWriter=\PHPExcel_IOFactory::createWriter($objPHPexcel,"Excel2007");
        $objWriter->save("php://output");
    }

       public function PeoExcleShow(){
           $input=Input::only("admin_classes_classes");
          
           if($input["admin_classes_classes"]==null){
               $People_data = DB::table("admin_classes")
                   ->leftJoin("classes","classes_id","=","admin_classes_classes")
                   ->where("admin_classes_company","=",session("now_company"))
                   ->get();
           }else{
               $People_data = DB::table("admin_classes")
                   ->leftJoin("classes","classes_id","=","admin_classes_classes")
                   ->where("admin_classes_company","=",session("now_company"))
                   ->where("admin_classes_classes",$input["admin_classes_classes"])
                   ->get();
           }
           $objPHPexcel=new \PHPExcel();
           $objSheet=$objPHPexcel->getActiveSheet();
           $objSheet->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)
               ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//水平垂直居中
           $objSheet->getDefaultStyle()->getFont()->setName("Times New Roman")->setSize(9);
           $objSheet->getStyle("A1:I1")->getFont()->setName("宋体")->setSize(11);//设置样式
           $objSheet->setTitle('人员信息表');
           $objSheet->setCellValue("A1","姓名")//换行
           ->setCellValue("B1","性别")
               ->setCellValue("C1","编码")
               ->setCellValue("D1","工作牌（学号）")
               ->setCellValue("E1","科室")
               ->setCellValue("F1","人员类别")
               ->setCellValue("G1","联系电话")
               ->setCellValue("H1","人员属性")
               ->setCellValue("I1","备注");
           $objSheet->getStyle("D1")->getAlignment()->setWrapText(true);
           $objSheet->getStyle("G1")->getAlignment()->setWrapText(true);
           $objSheet->getStyle("H1")->getAlignment()->setWrapText(true);
           foreach($People_data as $kv=>$gv){
               $kv=$kv+2;
               $objSheet->setCellValue("A".$kv,"$gv->admin_classes_name")
                   ->setCellValue("B".$kv,"$gv->admin_classes_sex")
                   ->setCellValue("C".$kv,"$gv->admin_classes_ides")
                   ->setCellValue("D".$kv,"$gv->admin_classes_num")
                   ->setCellValue("E".$kv,"$gv->classes_name")
                   ->setCellValue("F".$kv,"$gv->admin_classes_job")
                   ->setCellValue("G".$kv,"$gv->admin_classes_phone")
                   ->setCellValue("H".$kv,"$gv->admin_classes_class")
                   ->setCellValue("I".$kv,"$gv->admin_classes_add");
               $objSheet->getStyle("A".$kv)->getAlignment()->setWrapText(true);
               $objSheet->getStyle("B".$kv)->getAlignment()->setWrapText(true);
               $objSheet->getStyle("C".$kv)->getAlignment()->setWrapText(true);
               $objSheet->getStyle("D".$kv)->getAlignment()->setWrapText(true);
               $objSheet->getStyle("E".$kv)->getAlignment()->setWrapText(true);
               $objSheet->getStyle("F".$kv)->getAlignment()->setWrapText(true);
               $objSheet->getStyle("G".$kv)->getAlignment()->setWrapText(true);
               $objSheet->getStyle("H".$kv)->getAlignment()->setWrapText(true);
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
           out_browser("excle7",date("Y-m-d")."-RYXX");
           $objWriter=\PHPExcel_IOFactory::createWriter($objPHPexcel,"Excel2007");
           $objWriter->save("php://output");
       }

}
