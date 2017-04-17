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
<body>
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
            <li class="/classesadmin"><a>物资</a></li>
            <li><a href="/classesperson">人员</a></li>
            <li><a href="/classesdangernews">日志</a></li>
            <li><a href="/Classeslogout" style="color: red">退出</a></li>
        </ul>
    </div>
    </div>
</nav>
</div>
{{--头部结束--}}
<div style="height:100px;"></div>
{{--主体部分--}}
<div class="con-body">
    <div class="container">
        <div class="row">
            {{--左侧导航--}}
            <div  class="col-md-2">
                <ul class="nav nav-pills nav-stacked nav-sidebar" role="tablist" style="background:#F5F5F5;">
                    <li class="active"><a><h4>类别选择</h4></a></li>
                    <li id="YP_wh" class="active"><a href="javascript:;" onclick="YP_type(this.text)">危化品</a></li>
                    <li id="YP_cg"><a href="javascript:;" onclick="YP_type(this.text)">常规品</a></li>
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
                            <li><a>添加药品</a></li>
                        </ol>
                        <form class="form-horizontal" role="form">


                         {{--<div class="form-group">--}}
                                {{--<div class="col-md-2 control-label">--}}
                                    {{--<label class="sr-only">科室：</label>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-4">--}}
                                    {{--<input type="hidden" name="goods_classes" value="{{session('now_classes')}}"/>--}}
                                {{--</div>--}}
                         {{--</div>--}}
                        <div class="form-group">
                                <div class="col-md-2 control-label">
                                    <label>物品卡：</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="ids" class="form-control goods_ids" name="goods_ids" placeholder="请刷物品卡" readonly>
                                </div>
                                <div class="col-md-2 control-label">
                                    <label>危险等级：</label>
                                </div>
                                <div class="col-md-4">
                                    <select name="goods_dangerous" class="form-control goods_dangerous" id="dangerous">
                                        <option value="">无</option>
                                        @foreach($dangerous as $dangerous_v)
                                            <option value="{{$dangerous_v->dangerous_name}}">{{$dangerous_v->dangerous_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        <div class="form-group">
                            <div class="col-md-2 control-label">
                            <label>药品：</label>
                            </div>
                            <div class="col-md-4">
                            <input name="goods_name" class="form-control goods_name" type="text" placeholder="药瓶名称">
                            </div>
                            <div class="col-md-2 control-label">
                                <label>存储环境：</label>
                            </div>
                            <div class="col-md-4">
                                <select name="goods_store" class="form-control goods_store" id="store">
                                    <option value="">无</option>
                                    @foreach($store as $store_v)
                                        <option value="{{$store_v->store_name}}">{{$store_v->store_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            <div class="form-group">
                                <div class="col-md-2 control-label">
                                    <label>规格：</label>
                                </div>
                                <div class="col-md-4">
                                    <input name="goods_standard" class="form-control goods_standard" type="text" placeholder="药瓶规格">
                                </div>
                                <div class="col-md-2 control-label">
                                    <label>特性分类：</label>
                                </div>
                                <div class="col-md-4">
                                    <select name="goods_class" class="form-control goods_class" id="class">
                                        <option value="">无</option>
                                        @foreach($class as $class_v)
                                            <option value="{{$class_v->goods_class_name}}">{{$class_v->goods_class_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2 control-label">
                                    <label>单位：</label>
                                </div>
                                <div class="col-md-4">
                                    <select name="goods_units" class="form-control goods_units" id="nuits">
                                        @foreach($units as $nuits_v)
                                        <option value="{{$nuits_v->units_name}}">{{$nuits_v->units_name}}</option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 control-label">
                                    <label>用途：</label>
                                </div>
                                <div class="col-md-4">
                                    <select name="goods_usefor" class="form-control goods_usefor" id="usefor">
                                        <option value="">无</option>
                                        @foreach($usefor as $usefor_v)
                                            <option value="{{$usefor_v->usefor_name}}">{{$usefor_v->usefor_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2 control-label">
                                    <label>位置：</label>
                                </div>
                                <div class="col-md-4"> 
                                    <input name="goods_place" class="form-control goods_place" type="text" placeholder="药瓶位置">
                                </div>
                                <div class="col-md-2 control-label">
                                    <label>购买途径：</label>
                                </div>
                                <div class="col-md-4">
                                    <input id="TuJIN" name="goods_facture" class="form-control goods_facture" type="text" value="" placeholder="购买途径">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2 control-label">
                                    <label>帐管：</label>
                                </div>
                                <div class="col-md-4">
                                    <input name="goods_account_master" class="form-control goods_account_master"  value="{{$account[0]->admin_classes_name}}"  readonly>
                                </div>
                                <div class="col-md-2 control-label">
                                    <label>存储容器：</label>
                                </div>
                                <div class="col-md-4">
                                    <input id="RongQi" name="goods_container" class="form-control goods_container" type="text" value="" placeholder="存储容器">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2 control-label">
                                    <label>物管：</label>
                                </div>
                                <div class="col-md-4">
                                    <input name="goods_mcmater_master" class="form-control goods_mcmater_master"  value="{{$mcmater[0]->admin_classes_name}}"  readonly>
                                </div>
                                <div class="col-md-2 control-label">
                                    <label>危险化学品运输：</label>
                                </div>
                                <div class="col-md-4">
                                    <input id="YunShu" name="goods_trans" class="form-control goods_trans" type="text" value="" placeholder="危险化学品运输">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2 control-label">
                                    <label>总量：</label>
                                </div>
                                <div class="col-md-4">
                                    <input name="goods_all" class="form-control goods_all" type="number" placeholder="药瓶总量">
                                </div>
                                <div class="col-md-2 control-label">
                                    <label>生产厂家：</label>
                                </div>
                                <div class="col-md-4">
                                    <input id="goods_from" class="form-control goods_from" type="text" value="" placeholder="生产厂家">
                                </div>
                            </div>
                            <input type="hidden" value="{{$max_id}}" id="goods_id">
                            <input type="hidden" value="1" id="goods_info">  {{--判断添加的是常规品还是危化品--}}
                        </form>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="row">
                                    <div class="col-md-4"><a class="btn btn-primary  pull-left" href="{{url('classesadmin')}}">返回</a></div>
                                    <div class="col-md-4"><button onclick="return add_goods();" class="btn btn-danger pull-left " id="YP_add" disabled="disabled">添加</button></div>
                                    <div class="col-md-4"><button onclick='getval("ids","getCardid","YP_add")' class="btn btn-info  pull-left">获取卡ID</button></div>
                                </div>
                            </div>
                        </div>
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
function YP_type(val){
    if(val=="常规品"){
        $("#dangerous").attr("disabled","disabled");
        $("#store").attr("disabled","disabled");
        $("#class").attr("disabled","disabled");
        $("#RongQi").attr("disabled","disabled");
        $("#usefor").attr("disabled","disabled");
        $("#TuJIN").attr("disabled","disabled");
        $("#YunShu").attr("disabled","disabled");
        $("#YunShu").attr("disabled","disabled");
        $("#goods_from").attr("disabled","disabled");
        $("#ids").val("");
        $("#dangerous").val("");
        $("#store").val("");
        $("#class").val("");
        $("#RongQi").val("");
        $("#usefor").val("");
        $("#TuJIN").val("");
        $("#YunShu").val("");
        $("#goods_from").val("");
        $("#YP_cg").addClass("active");
        $("#YP_wh").removeClass("active");
        $("#YP_type2").text("常规品");
        $("#goods_info").val("2");
    }else{
        $("#dangerous").removeAttr("disabled");
        $("#store").removeAttr("disabled");
        $("#class").removeAttr("disabled");
        $("#RongQi").removeAttr("disabled");
        $("#usefor").removeAttr("disabled");
        $("#TuJIN").removeAttr("disabled");
        $("#YunShu").removeAttr("disabled");
        $("#goods_from").removeAttr("disabled");
        $("#YP_cg").removeClass("active");
        $("#YP_wh").addClass("active");
        $("#YP_type2").text("危化品");
        $("#goods_info").val("1");
    }
}
    function add(id){
        if($("#goods_info").val()==1){
            $data={
                '_token':'{{csrf_token()}}',
                'goods_id':id,
                'goods_info':$("#goods_info").val(),
                'goods_dangerous':$(".goods_dangerous option:selected").val(),
                'goods_name':$(".goods_name").val(),
                'goods_store':$(".goods_store option:selected").val(),
                'goods_standard':$(".goods_standard").val(),
                'goods_class':$(".goods_class option:selected").val(),
                'goods_units':$(".goods_units option:selected").val(),
                'goods_usefor':$(".goods_usefor option:selected").val(),
                'goods_place':$(".goods_place").val(),
                'goods_facture':$(".goods_facture").val(),
                'goods_account_master':$(".goods_account_master").val(),
                'goods_container':$(".goods_container").val(),
                'goods_mcmater_master':$(".goods_mcmater_master").val(),
                'goods_trans':$(".goods_trans").val(),
                'goods_all':$(".goods_all").val(),
                'goods_in':$(".goods_all").val(),
                'goods_out':0,
                'goods_now':$(".goods_all").val(),
                'goods_from':$(".goods_from").val(),
                'goods_ids':$("#ids").val(),
            }
        }else{
            $data={
                '_token':'{{csrf_token()}}',
                'goods_id':id,
                'goods_info':$("#goods_info").val(),
                'goods_name':$(".goods_name").val(),
                'goods_standard':$(".goods_standard").val(),
                'goods_units':$(".goods_units option:selected").val(),
                'goods_place':$(".goods_place").val(),
                'goods_account_master':$(".goods_account_master").val(),
                'goods_mcmater_master':$(".goods_mcmater_master").val(),
                'goods_all':$(".goods_all").val(),
                'goods_in':$(".goods_all").val(),
                'goods_out':0,
                'goods_now':$(".goods_all").val(),
                'goods_ids':$("#ids").val(),
            }
        }
        $url="{{url('classesadmin')}}";
        $.post($url,$data,function(data){
            if(data.status==1){
                layer.msg(data.msg, {icon:6});
                $("#YP_add").attr("disabled");
                $("#goods_id").val(parseInt(Date.parse(new Date())+Math.random()*10000));
                $("#ids").val("");
                $(".goods_dangerous").val("");
                $(".goods_store").val("");
                $(".goods_standard").val("");
                $(".goods_class").val("");
                $(".goods_usefor").val("");
                $(".goods_place").val("");
                $(".goods_facture").val("");
                $(".goods_container").val("");
                $(".goods_trans").val("");
                $(".goods_all").val("");
                $(".goods_from").val("");
                $(".goods_name").val("");
            }else{
				$("#goods_id").val(parseInt(Date.parse(new Date())+Math.random()*10000));
                layer.msg(data.msg, {icon:5});
            }
        },"JSON");
    }


function add_goods(){
    var GoodsId=$("#goods_id").val();
    if($("#add_classes_id").val()==""||$("#add_classes_classes").val()==""){
        layer.msg("请连接终端！", {time: 5000, icon:6});
        return false;
    }else{
                var goods_id=GoodsId;
                var goods_info=$("#goods_info").val();
                var goods_dangerous=$(".goods_dangerous option:selected").val();
                var goods_name=$(".goods_name").val();
                var goods_store=$(".goods_store option:selected").val();
                var goods_standard=$(".goods_standard").val();
                var goods_class=$(".goods_class option:selected").val();
                var goods_units=$(".goods_units option:selected").val();
                var goods_usefor=$(".goods_usefor option:selected").val();
                var goods_place=$(".goods_place").val();
                var goods_facture=$(".goods_facture").val();
                var goods_account_master=$(".goods_account_master").val();
                var goods_container=$(".goods_container").val();
                var goods_mcmater_master=$(".goods_mcmater_master").val();
                var goods_trans=$(".goods_trans").val();
                var goods_all=$(".goods_all").val();
                var goods_in=$(".goods_all").val();
                var goods_out=0;
                var goods_now=$(".goods_all").val();
                var goods_from=$(".goods_from").val();
                var goods_ids=document.getElementById("ids").value;
                var goods_company={{session("now_company")}};
                var goods_time='{{date("Y-m-d H.i.s")}}';
                var goods_classes='{{$classes}}';
	
	    if(goods_info==1){
		           if(goods_id&&goods_dangerous&&goods_name&&goods_store&&goods_standard&&goods_class&&goods_units&&goods_usefor&&goods_place&&goods_facture&&goods_container&&goods_trans&&goods_all&&goods_from&&goods_ids&&goods_company&&goods_classes){
                    var info="INSERT INTO `new_whp`.`goods` (`goods_id`, `goods_name`, `goods_class`, `goods_dangerous`, `goods_store`, `goods_standard`, `goods_facture`, `goods_from`, `goods_usefor`, `goods_place`,"
                    +"`goods_container`, `goods_trans`, `goods_units`, `goods_all`, `goods_in`, `goods_out`, `goods_now`, `goods_account_master`, `goods_mcmater_master`,"
                    +"`goods_classes`,`goods_info`, `goods_time`, `goods_company`, `goods_ids`) VALUES (?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?);:"
                    +goods_id+","+goods_name+","+goods_class+","+goods_dangerous+","+goods_store+","+goods_standard+","+goods_facture+","+goods_from+","+goods_usefor+","+goods_place+","+goods_container+","+goods_trans+","+goods_units+","+goods_all+","+goods_in+","+goods_out+","+goods_now+","+goods_account_master+","+goods_mcmater_master+","+goods_classes+","+goods_info+","+goods_time+","+goods_company+","+goods_ids;				      
			        }else{
						layer.msg("请检查输入", {time: 5000, icon:5});
				       exit();
					}
                 			
        }else{
			        if(goods_id&&goods_name&&goods_standard&&goods_place&&goods_units&&goods_all&&goods_classes&&goods_company&&goods_ids){
                    var info="INSERT INTO `new_whp`.`goods` (`goods_id`, `goods_name`,  `goods_standard`,   `goods_place`,"+" `goods_units`, `goods_all`, `goods_in`, `goods_out`, `goods_now`, `goods_account_master`, `goods_mcmater_master`,"+"`goods_classes`,`goods_info`, `goods_time`, `goods_company`, `goods_ids`) VALUES (?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);:"
                    +goods_id+","+goods_name+","+goods_standard+","+goods_place+","+goods_units+","+goods_all+","+goods_in+","+goods_out+","+goods_now+","+goods_account_master+","+goods_mcmater_master+","+goods_classes+","+goods_info+","+goods_time+","+goods_company+","+goods_ids;     
					}else{
						layer.msg("请检查输入", {time: 5000, icon:5});
				        exit();
					}
  }
        var url="http://42.96.150.102/hou/httpHandler.do";
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
                                add(goods_id);
                            }else if(bag_id=="error"){
                                layer.msg("遇到不可逆问题，需重启同步终端。", {time: 5000, icon:6});                                //$("#user_form").submit();
                                //证明终端上有卡号服务器上边没有。
                                //给终端发送一个请求得到该卡号信息的请求，弹出对话框：检测终端上边该卡号
                                //已被录入，可能因为其它原因服务器上边并没有该卡号数据
                                //显示数据后询问是否添加上一次数据
                                return false;
                            }
                        },
                        error: function() {
                            document.getElementById(info_id).innerText="请检查终端是否有反应，刷卡是否正确！";
                        }
                    }
            );
	}
        return false;
}

//判断终端有没有该卡ID
function judge_ids(id,sumbit_id){
    var data={"bag_id":"judge_id","info":id,"terminal_id":{{session("now_classes")}}};
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
                    if(bag_id=="judge_id"){
                        layer.msg(json.info, {time: 5000, icon:6});
                        $("#"+sumbit_id).removeAttr("disabled");
                    }else if(bag_id=="error"){
                        $("#ids").val("");
                        layer.msg(json.info, {time: 5000, icon:5});
                        $("#"+sumbit_id).attr("disabled","disabled");
                    }
                },
                error: function() {
                    document.getElementById(info_id).innerText="请检查终端是否有反应，刷卡是否正确！";
                }
            }
    );
}
//获取制作卡的ID并且判断终端有无此ID
function getval(view_classes_id,bag_name,sumbit_id){
    $.ajax({
                type:"get",
                async: false,
                url:"http://120.76.245.91:888/hou/httpHandler.do?bag_id="+bag_name+"&terminal_id="+{{session("now_classes")}}+"&info=",
                dataType: "jsonp",
                jsonp: "mugui",
                jsonpCallback:"end",
                cache:false,
                success: function(json){
                    var bag_id=json.bag_id;
                    if(bag_id=="terminal"){
                        layer.msg(json.info, {time: 5000, icon:6});
                    }else if(bag_id=="error"){
                        layer.msg(json.info, {time: 5000, icon:5});
                    }else if(bag_id=="getCardid"){
                        document.getElementById(view_classes_id).value=json.info;
                        judge_ids(json.info,sumbit_id);
                    }
                },
                error: function() {
                    layer.msg("请检查终端是否有反应，刷卡是否正确！", {icon: 5});
                }
            }
    );
}
</script>
</body>
</html>
