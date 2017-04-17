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
            <li class="active"><a>物资</a></li>
            <li><a href="/secondAdmins">人员</a></li>
            <li><a href="/dangernews">日志</a></li>
            <li><a href="/logout" style="color: red">退出</a></li>
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
                        <div class="form-group">
                            <div class="col-md-2 control-label">
                                <label>科室：</label>
                            </div>
                            <div class="col-md-4">
                                <select name="goods_classes" class="form-control goods_classes">
                                    @foreach($classes as $classes_c)
                                    <option value="{{$classes_c->classes_id}}">{{$classes_c->classes_name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 control-label">
                                <label>危险等级：</label>
                            </div>
                            <div class="col-md-4">
                                <select name="goods_dangerous" class="form-control goods_dangerous" id="dangerous">
                                    <option value=>无</option>
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
                                    <option value=>无</option>
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
                                        <option value=>无</option>
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
                                        <option value=>无</option>
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
                                    <input id="TuJIN" name="goods_facture" class="form-control goods_facture" type="text" placeholder="购买途径">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2 control-label">
                                    <label>帐管：</label>
                                </div>
                                <div class="col-md-4">
                                    <select name="goods_account_master" class="form-control goods_account_master" name="nuits">
                                        @foreach($user as $user_v)
                                            <option value="{{$user_v->admin_classes_name}}">{{$user_v->admin_classes_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 control-label">
                                    <label>存储容器：</label>
                                </div>
                                <div class="col-md-4">
                                    <input id="RongQi" name="goods_container" class="form-control goods_container" type="text" placeholder="存储容器">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2 control-label">
                                    <label>物管：</label>
                                </div>
                                <div class="col-md-4">
                                    <select name="goods_mcmater_master" class="form-control goods_mcmater_master" name="nuits">
                                        @foreach($user as $user_v)
                                            <option value="{{$user_v->admin_classes_name}}">{{$user_v->admin_classes_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 control-label">
                                    <label>危险化学品运输：</label>
                                </div>
                                <div class="col-md-4">
                                    <input id="YunShu" name="goods_trans" class="form-control goods_trans" type="text" placeholder="危险化学品运输">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2 control-label">
                                    <label>总量：</label>
                                </div>
                                <div class="col-md-4">
                                    <input name="goods_all" class="form-control goods_all" type="text" placeholder="药瓶总量">
                                </div>
                                <div class="col-md-2 control-label">
                                    <label>生产厂家：</label>
                                </div>
                                <div class="col-md-4">
                                    <input id="goods_from" class="form-control goods_from" type="text" placeholder="生产厂家">
                                </div>
                            </div>
                            <input type="hidden" value="1" id="goods_info">  {{--判断添加的是常规品还是危化品--}}
                        </form>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-4">
                                <a class="btn btn-primary btn-lg pull-left" href="{{url('admin')}}">返回</a>
                                <button class="btn btn-danger btn-lg pull-right" id="YP_add">添加</button>
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
        $("#dangerous").val("");
        $("#store").val("");
        $("#class").val("");
        $("#RongQi").val("");
        $("#usefor").val("");
        $("#TuJIN").val("");
        $("#YunShu").val("");
        $("#YunShu").val("");
        $("#goods_from").val("");
        $("#YP_cg").addClass("active");
        $("#YP_wh").removeClass("active");
        $("#YP_type2").text("常规品");
        $("#goods_info").attr("value","2");
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
        $("#goods_info").attr("value","1");
    }
}
    $("#YP_add").click(function(){
        if($("#goods_info").val()==1){
            $data={
                '_token':'{{csrf_token()}}',
                'goods_info':$("#goods_info").val(),
                'goods_classes':$(".goods_classes option:selected").val(),
                'goods_dangerous':$(".goods_dangerous").val(),
                'goods_name':$(".goods_name").val(),
                'goods_store':$(".goods_store").val(),
                'goods_standard':$(".goods_standard").val(),
                'goods_class':$(".goods_class").val(),
                'goods_units':$(".goods_units option:selected").val(),
                'goods_usefor':$(".goods_usefor").val(),
                'goods_place':$(".goods_place").val(),
                'goods_facture':$(".goods_facture").val(),
                'goods_account_master':$(".goods_account_master option:selected").val(),
                'goods_container':$(".goods_container").val(),
                'goods_mcmater_master':$(".goods_mcmater_master option:selected").val(),
                'goods_trans':$(".goods_trans").val(),
                'goods_all':$(".goods_all").val(),
                'goods_in':$(".goods_all").val(),
                'goods_out':0,
                'goods_now':$(".goods_all").val(),
                'goods_from':$(".goods_from").val(),
            }
        }else{
            $data={
                '_token':'{{csrf_token()}}',
                'goods_info':$("#goods_info").val(),
                'goods_classes':$(".goods_classes option:selected").val(),
                'goods_name':$(".goods_name").val(),
                'goods_standard':$(".goods_standard").val(),
                'goods_units':$(".goods_units option:selected").val(),
                'goods_place':$(".goods_place").val(),
                'goods_account_master':$(".goods_account_master option:selected").val(),
                'goods_mcmater_master':$(".goods_mcmater_master option:selected").val(),
                'goods_all':$(".goods_all").val(),
                'goods_in':$(".goods_all").val(),
                'goods_out':0,
                'goods_now':$(".goods_all").val(),
            }
        }
        $url="{{url('admin')}}";
        $.post($url,$data,function(data){
            if(data.status==1){
                layer.msg(data.msg, {icon:6});
                $(".goods_dangerous").val("");
                $(".goods_name").val("");
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
            }else{
                layer.msg(data.msg, {icon:5});
            }
        },"JSON");
    })
</script>
</body>
</html>
