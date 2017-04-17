<?php
header("Cache-Control: no-cache, must-revalidate");
header("Pramga: no-cache");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="ie-stand">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap-theme.min.css')}}">
</head>
<body onload="load_type();">
<div style="height:100%;width:100%;z-index:-10;position:fixed;">
    <img style="height:100%;width:100%" src="{{url('img/bg1.jpg')}}">
</div>
<div class="con-header">
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
    <div class="navbar-header">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-responsive-collapse">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="javascript:;" class="navbar-brand">实验物品辅助管理系统</a>
    </div>
    <div class="collapse navbar-collapse navbar-responsive-collapse pull-right">
        <ul class="nav navbar-nav">
            <li  class="active"><a href="/admin">物资</a></li>
            <li><a href="/classesperson">人员</a></li>
            <li><a href="/classesdangernews">日志</a></li>
            <li><a href="/Classeslogout" style="color: red">退出</a></li>
        </ul>
    </div>
    </div>
</nav>
</div>
{{--头部结束--}}
<div style="height:50px;"></div>
{{--主体部分--}}
<div class="con-body">
    <div class="container">
        <div class="row">
            {{--左侧导航--}}
            <div  class="col-md-2">
                <ul class="nav nav-pills nav-stacked nav-sidebar" role="tablist" style="background:#F5F5F5;border-radius: 10px;">
                    <li class="active"><a><h4>类别选择</h4></a></li>
                    <li id="YP_wh" class="active"><a href="javascript:;">危化品</a></li>
                    <li id="YP_cg"><a id="Link_cg" href="javascript:;">常规品</a></li>
                </ul>
            </div>
            <style type="text/css">
                /* Sidebar navigation */
                .nav-sidebar {
                    margin-right:-15px;
                    margin-bottom: 20px;
                    margin-left: -15px;

                }
                .nav-sidebar > li > a {
                    padding-right: 20px;
                    padding-left: 20px;
                }
                .nav-sidebar > .active > a,
                .nav-sidebar > .active > a:hover,
                .nav-sidebar > .active > a:focus {
                    color: #fff;
                    background-color: #428bca;
                }
            </style>
            {{--右侧内容--}}
            <div class="col-md-10" >
                <div class="panel panel-default">
                    <div class="panel-body" >
                        <ol class="breadcrumb">
                            <li><a>首页</a></li>
                            <li><a id="YP_type2">危化品</a></li>
                            <li><a>药品盘点</a></li>
                        </ol>
                        @if(count($errors)>0)
                            @foreach($errors->all() as $error)
                                <div class="alert alert-warning alert-dismissible text-center" role="alert">
                                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <strong>{{$error}}</strong>
                                </div>
                            @endforeach
                        @endif
                        <form action="{{url('classesadmin/'.$goods->goods_ids)}}" id="form_id" method="post" class="form-horizontal" role="form">
                            <input type="hidden" value="{{csrf_token()}}" name="_token">
                            <input type="hidden" value="put" name="_method">
                        <div class="form-group">
                            <div class="col-md-2 control-label">
                                <label>药品名称：</label>
                            </div>
                            <div class="col-md-4">
                                <input value="{{$goods->goods_name}}" name="goods_name" class="form-control" type="text" placeholder="药品名称" required readonly>
                            </div>
                            <div class="col-md-2 control-label">
                                <label>现量：</label>
                            </div>
                            <div class="col-md-4">
                                <input name="goods_now" id="goods_now" value="{{$goods->goods_now}}" class="form-control" type="text" placeholder="药品现量" required>
                            </div>
                            <input type="hidden" value="{{$goods->goods_ids}}" id="goods_ids">
                            <input type="hidden" value="{{$goods->goods_info}}" id="goods_info" name="goods_info">
                        </div>
                            <div class="form-group">
                                <div class="col-md-2 control-label">
                                    <label>单位：</label>
                                </div>
                                <div class="col-md-4">
                                    <input name="goods_units" id="goods_units" value="{{$goods->goods_units}}" class="form-control" type="text" placeholder="药品单位" required readonly>
                                </div>
                                <div class="col-md-2 control-label">
                                    <label>规格：</label>
                                </div>
                                <div class="col-md-4">
                                    <input name="goods_standard" id="goods_standard" value="{{$goods->goods_standard}}" class="form-control" type="text" placeholder="药品规格" required >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2 control-label">
                                    <label>存放位置：</label>
                                </div>
                                <div class="col-md-4">
                                    <input name="goods_place" id="goods_place" value="{{$goods->goods_place}}" class="form-control" type="text" placeholder="存放位置" required >
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-md-offset-4">
                                    <a class="btn btn-primary  pull-left" href="{{url('classesadmin')}}">返回</a>
                                    <button class="btn btn-danger pull-right" onclick="return up_goods();">修改</button>
                                </div>
                            </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('layer/layer.js')}}"></script>
<script language="javascript">
    function load_type(){
        if($("#goods_info").val()==1){

        }else{
            $("#YP_cg").addClass("active");
            $("#YP_wh").removeAttr("class");
            $("$YP_type2").text("常规品");
        }
    }

    function up_goods(){
           var goods_ids=$("#goods_ids").val();
           var goods_now=$("#goods_now").val();
           var goods_all=$("#goods_now").val();
           var goods_place=$("#goods_place").val();
           var goods_standard=$("#goods_standard").val();
           var goods_in=0;
           var goods_out=0;
           var info="UPDATE `new_whp`.`goods` SET `goods_all`=?,`goods_in`=?,`goods_out`=?,`goods_place`=?,`goods_standard`=?,`goods_now`=? WHERE `goods_ids`=?;:"+goods_all+","+goods_in+","+goods_out+","+goods_place+","+goods_standard+","+goods_now+","+goods_ids;
            var data={"bag_id":"updateSql","info":info,"terminal_id":{{session("now_classes")}}};
            $.ajax({
                        type:"post",
                        async: false,
                        url:"http://120.76.245.91:888/hou/httpHandler.do",
                        dataType: "jsonp",
                        jsonp: "mugui",
                        jsonpCallback:"end",
                        data:data,
                        cache:false,
                        success: function(json){	
                            var bag_id=json.bag_id;
                            if(bag_id=="updateSql"){
                                $("#form_id").submit();
                            }else if(bag_id=="error"){
                                layer.msg(json.info, {time: 5000, icon:5});
                                //$("#user_form").submit();
                                //证明终端上有卡号服务器上边没有。
                                //给终端发送一个请求得到该卡号信息的请求，弹出对话框：检测终端上边该卡号
                                //已被录入，可能因为其它原因服务器上边并没有该卡号数据
                                //显示数据后询问是否添加上一次数据
                                return false;
                            }
                        },
                        error: function() {
                            layer.msg("警告：程序出现异常", {time: 5000, icon:5});
                        }
                    }
            );
            return false;
        }
</script>
</body>
</html>
