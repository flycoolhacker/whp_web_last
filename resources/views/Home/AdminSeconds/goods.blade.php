<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="ie-stand">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('boot
<body>strap/css/bootstrap-theme.min.css')}}">
</head>
<div style="height:100%;width:100%;z-index:-10;position:fixed;">
    <img style="height:100%;width:100%" src="img/bg1.jpg">
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
            <li class="active"><a href="/admin">物资</a></li>
            <li><a href="/secondAdmins">人员</a></li>
            <li><a href="/classes">科室管理</a></li>
            <li><a href="/dangernews">日志</a></li>
            <li><a href="/logout" style="color: red">退出</a></li>
        </ul>
    </div>
    </div>
</nav>
</div>
{{--头部结束--}}
<div style="height:50px;"></div>
 @if(session('__Ajax_RedirectFunc_status') == true)
        <div>
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3>成功</h3>
                <p><?php echo session('__Ajax_RedirectFunc_message');?></p>
                <p><?php echo session('__Ajax_RedirectFunc_plugin');?></p>
            </div>
        </div>
    @endif
    @if(session('__Ajax_RedirectFunc_status') === false)
        <div >
            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3>失败</h3>
                <p><?php echo session('__Ajax_RedirectFunc_message');?></p>
                <p><?php echo session('__Ajax_RedirectFunc_plugin');?></p>
            </div>
        </div>
    @endif
{{--主体部分--}}
<div class="con-body">
   
    <div class="container">
        <div class="row">
            {{--左侧导航--}}
            <div  class="col-md-2" style="border-radius:10px;">
                <ul class="nav nav-pills nav-stacked nav-sidebar" role="tablist" style="border-radius:10px;background:#F5F5F5;">
                    <li class="active"><a><h4>搜索</h4></a></li>
                    <form action="{{url('Seek')}}" method="get" role="form">
                        <li><input name="SeekName" value="{{$Seek}}" class="form-control" type="text" placeholder="按药品名称查找"></li>
                        <li><button type="submit" class="btn btn-default btn-sm form-control">搜索</button></li>
                    </form>
                </ul>
                <div style="background:#F5F5F5;margin-left:-15px;margin-right:-15px; border-radius: 10px;">
                <form action="{{url('admin')}}" method="get">
                <ul class="nav nav-pills nav-stacked" role="tablist">
                    <li class="active"><a><h4>类别选择</h4></a></li>
                    <br/>
                    <li><select name="YP_type" class="form-control">
                            <option @if($KSclass["YP_type"]==0)
                                    selected
                                    @endif
                                    value="0">全部药品</option>
                            <option @if($KSclass["YP_type"]==1)
                                    selected
                                    @endif
                                    value="1">危化品</option>
                            <option @if($KSclass["YP_type"]==2)
                                    selected
                                    @endif
                                    value="2">常规品</option>
                        </select></li>
                    <br/>
                </ul>
                <ul class="nav nav-pills nav-stacked" role="tablist">
                    <li class="active"><a><h4>科室选择</h4></a></li>
                    <br/>
                    <li>
                        <select name="KS_select" class="form-control">
                            <option @if($KSclass["KS_select"]==0)
                                    selected
                                    @endif
                                    value="0">所有科室</option>
                            @foreach($ClassesData as $Cv)
                                <option @if(strcmp($KSclass["KS_select"],$Cv->classes_id)==0)
                                        selected
                                        @endif
                                        value="{{$Cv->classes_id}}">{{$Cv->classes_name}}</option>
                                @endforeach
                        </select>
                    </li>
                    <br/>
                    <li><button id="KS_submit" type="submit" class="btn btn-default form-control">提交</button></li>
                </ul>
                </form>
                </div>
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
                            <li><a href="javascript:;">首页</a></li>
                            <li><a>@if($KSclass["YP_type"]==0)
                                        全部药品
                                    @elseif($KSclass["YP_type"]==1)
                                       危化品
                                    @elseif($KSclass["YP_type"]==2)
                                       常规品
                                    @else
                                        全部药品
                                    @endif</a></li>
                            <li><a>@if($KSclass["KS_select"])
                                        @foreach($ClassesData as $Cv)
                                            @if(strcmp($KSclass["KS_select"],$Cv->classes_id)==0)
                                                    {{$Cv->classes_name}}
                                                    @endif
                                        @endforeach
                                       @else
                                       全部科室
                                       @endif
                                </a></li>
                        </ol>
                        <div class="row">
                        <div class="col-md-8">
                            <form action="{{url('/TimeShow')}}"  target="_blank" method="get" class="form-inline" role="form">
                                <div class="form-group">
                                    <label class="sr-only" for="starttime">开始时间</label>
                                    <input type="text" name="starttime" class="form-control" id="starttime" placeholder="起始时间:2020-01-01" required>
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="stoptime">终止时间</label>
                                    <input type="text" name="stoptime" class="form-control" id="stoptime" placeholder="终止时间:2020-12-31" required>
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="">药品类型</label>
                                    <input type="hidden" name="YP_type" id="YP_type" value="{{$KSclass["YP_type"]}}">
                                </div>
								<input type="hidden" name="classes" value="{{$KSclass["KS_select"]}}">
                                <button type="submit" class="btn btn-info btn-sm" onclick="return Look_Methed();">查看消耗量汇总表</button>
                                <script>
                                    function Look_Methed(){
                                        var time_layout=new RegExp("^[0-9]{4}-[0-9]{2}-[0-9]{2}$")
                                        if($("#YP_type").val()){
                                            if($("#YP_type").val()=="0"){
                                                layer.msg("请选择类别", {icon: 5});
                                                return false;
                                            }else if(time_layout.test($("#starttime").val())&&time_layout.test($("#stoptime").val())){
                                                return true;
                                            }else{
                                                layer.msg("请按正确格式填写：xxxx-xx-xx", {icon: 5});
                                                return false;
                                            }
                                        }else{
                                            layer.msg("请选择类别", {icon: 5});
                                            return false;
                                        };
                                    }
                                </script>
                            </form>
                        </div>
                        <div class="col-md-2">
                            @if($KSclass["YP_type"]==1)
                               <form action="{{url('/ExcleShow1')}}" target="_blank" method="post" class="form-inline" role="form">
                                   @else
                                       <form action="{{url('/NomalExcleShow1')}}" target="_blank" method="post" class="form-inline" role="form">
                                       @endif
                                   {{csrf_field()}}
                                   <div class="form-group">
                                       <label class="sr-only" for="">科室</label>
                                       <input type="hidden" name="classes" value="{{$KSclass["KS_select"]}}">
                                   </div>
                                   <div class="form-group">
                                       <label class="sr-only" for="">药品类型</label>
                                       <input type="hidden" name="YP_type" value="{{$KSclass["YP_type"]}}">
                                   </div>
                                   <div class="pull-right">
                                       <button type="submit" class="btn btn-info btn-sm" onclick="return Look_Methed1();">导出库存表</button>
                                   </div>
                               </form>
                            <script>
                                function Look_Methed1() {
                                    if ($("#YP_type").val()) {
                                        if ($("#YP_type").val() == "0") {
                                            layer.msg("请选择类别", {icon: 5});
                                            return false;
                                        } else {
                                            return true;
                                        }
                                    } else {
                                        layer.msg("请选择类别", {icon: 5});
                                        return false;
                                    }
                                }
                            </script>
                           </div>
                            <div class="col-md-2">
                                <div class="form-group pull-right">
                                    {{--<a class="btn btn-primary btn-sm" href="{{url('classesadmin/create')}}">添加药品</a>--}}
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    {{--<a class="btn btn-danger btn-sm" onclick="PL_del();">删除所选</a>--}}
                                </div>
                            </div>
                        </div>
                        <br>
                        <h4 style="color:red;">1为危化品，2为常规品</h4>
                        <hr/>
                        <div class="table-responsive">
                        <table class="table table-bordered table-responsive table-striped table-hover">
                            <thead>
                            <tr>
                                <th><span class="glyphicon glyphicon-th-large"></span>类别</th>
                                <th><span class="glyphicon glyphicon-th-large"></span>物品</th>
                                <th><span class="glyphicon glyphicon-paperclip"></span>规格</th>
                                <th><span class="glyphicon glyphicon-edit"></span>单位</th>
                                <th><span class="glyphicon glyphicon-home"></span>现量</th>
                                <th><span class="glyphicon glyphicon-map-marker"></span>位置</th>
                                <th  style="width:150px;"><span class="glyphicon glyphicon-map-marker"></span>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($NormalData as $Nv)
                                    <!-- Modal -->
                            <div class="modal fade" id="{{(int)($Nv->goods_id)}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title" id="myModalLabel">当前物品：{{$Nv->goods_name}}</h4>
                                        </div>
                                        <div class="modal-body">
					    <h4>存放位置：{{$Nv->goods_place}}</h4>
					    <h4>规格：{{$Nv->goods_standard}}</h4>
					    <h4>现量：{{$Nv->goods_now}}</h4>
					    <h4>单位：{{$Nv->goods_units}}</h4>
					    <h4>用途：{{$Nv->goods_usefor}}</h4>
					    <h4>存储容器：{{$Nv->goods_container}}</h4>
					    <h4>特性：{{$Nv->goods_class}}</h4>
					    <h4>危险度：{{$Nv->goods_dangerous}}</h4>
                                            <h4>存储环境：{{$Nv->goods_store}}</h4>
                                            <h4>生产厂家：{{$Nv->goods_facture}}</h4>
                                            <h4>购买途径：{{$Nv->goods_from}}</h4>
                                            <h4>运输方式：{{$Nv->goods_trans}}</h4> 
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">返回</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <tr>
                                    <td>{{$Nv->goods_info}}</td>
                                    <td>{{$Nv->goods_name}}</td>
                                    <td>{{$Nv->goods_standard}}</td>
                                    <td>{{$Nv->goods_units}}</td>
                                    <td>{{$Nv->goods_now}}</td>
                                    <td>{{$Nv->goods_place}}</td>
                                <td>
                                    {{--<input name="check" value="{{$Nv->goods_id}}" type="checkbox">--}}
                                    <button type="button" class=" form-control btn btn-info btn-xs" data-toggle="modal" data-target="#{{(int)($Nv->goods_id)}}">详情</button>
                                    {{--<a type="button" class="btn btn-warning btn-xs" href="{{url('admin/'.$Nv->goods_id.'/edit')}}">盘点</a>--}}
                                    {{--<button type="button" onclick="NormDelete({{$Nv->goods_id}})" class="btn btn-danger btn-xs">删除</button>--}}
                               </td>
                               </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        <ul id="fenye" class="list">
                            {!! $NormalData->appends(['SeekName'=>$Seek])->appends(['YP_type'=>$KSclass["YP_type"]])->appends(['KS_select' => $KSclass["KS_select"]])->links() !!}
                        </ul>
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
function PL_del() {
    var length =$("input[type='checkbox']:checked").length;
    if(length>0){
        layer.confirm('确定删除？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            var check =$("input[type='checkbox']");
            var len = check.length;
            var idAll = "";
            for (var i = 0; i < len; i++) {
                if (check[i].checked) {
                    idAll += check[i].value + ",";
                }
            }
            $.post('DeleteAll',{'_token':'{{csrf_token()}}','idAll':idAll,'length':length,},function(data){
                if(data.status==1){
                    layer.msg(data.msg, {icon: 6});
                    location.href=location.href;
                }else{
                    layer.msg(data.msg, {icon: 5});
                }
            },"json")
        }, function(){
        });
    }else{
        layer.msg('请选择！', {icon: 5});
    }

}
function NormDelete(id){
    layer.confirm('确定删除？', {
        btn: ['确定','取消'] //按钮
    }, function(){
        $.post('admin/'+id,{'_method':'delete','_token':'{{csrf_token()}}'},function(data){
            if(data.status==1){
                layer.msg(data.message, {icon: 6});
                location.href=location.href;
            }else{
                layer.msg(data.message, {icon: 5});
            }
        },"json")
    }, function(){
    });
}
</script>
</body>
</html>
