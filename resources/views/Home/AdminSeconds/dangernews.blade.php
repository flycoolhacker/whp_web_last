<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="ie-stand">
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap-theme.min.css')}}">
</head>
<body>
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
            <li><a href="/admin">物资</a></li>
            <li><a href="/secondAdmins">人员</a></li>
            <li><a href="/classes">科室管理</a></li>
            <li  class="active"><a href="/dangernews">日志</a></li>
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
                    <li class="active"><a href="/dangernews">危化品</a></li>
                    <li><a href="/normalnews">常规品</a></li>
                </ul>
                <br>
                <form action="/dangernews" method="get">
                <ul class="nav nav-pills nav-stacked nav-sidebar" role="tablist" style="background:#F5F5F5;">
                    <li class="active"><a><h4>科室选择</h4></a></li>
                        <br>
                        <li>
                            <select name="KS_select" class="form-control">
                                <option @if(strcmp($KSclass["KS_select"],"")==0)
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
                    <br>
                        <li><button id="KS_submit" type="submit" class="btn btn-default form-control">提交</button></li>
                </ul>
                </form>
            </div>
            {{--右侧内容--}}
            <div class="col-md-10" >
                <div class="panel panel-default">
                    <div class="panel-body" >
                        <ol class="breadcrumb">
                            <li><a>首页</a></li>
                            <li><a>危化日志</a></li>
                            <li><a>@foreach ($nowClasses as $data) {{$data->classes_name}} @endforeach</a></li>
                        </ol>
                        <div class="form-inline" role="form">
                            <div class="row">
                            <div class="col-md-4">
                            <form action="#" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                排序：<select class="form-control" name="desc" value="{{ csrf_token() }}" >
                                    <option value="时间"
                                            @if($desc['desc']=="时间")selected
                                            @endif>时间</option>
                                    <option value="物品"
                                            @if($desc['desc']=="物品")selected
                                            @endif>物品</option>
                                    <option value="领用"
                                            @if($desc['desc']=="领用")selected
                                            @endif>领用人</option>
                                    </select>
                                <button class="btn btn-primary" type="submit">确认</button>
                                </form>
                            </div>
                                <div class="col-md-8">
                            <form target="_blank" action="/SeclogTimeShow" method="get" class="form-inline" role="form">
                                <input type="hidden" id="LookController" value='{{$KSclass["KS_select"]}}' name="id_classes">
                                <label class="pull-right">
                                    <div class="form-group">
                                        <label class="sr-only" for="starttime">开始时间</label>
                                        <input type="text" id="starttime" name="starttime" class="form-control" placeholder="开始时间:2020-01-01" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="stoptime">终止时间</label>
                                        <input type="text" id="stoptime" name="stoptime" class="form-control" placeholder="结束时间:2020-12-31" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="order">排序</label>
                                        <input type="hidden" id="order" value="{{$desc['desc']}}" name="desc">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="YP_type">药品类型</label>
                                        <input type="hidden" id="YP_type" value="1" name="YP_type">
                                    </div>
                                    <button class="btn btn-info btn-sm" onclick="return Look_Controller();" type="submit">查看出入库记录表</button>
                                    <script>
                                        function Look_Controller(){
                                            var time_layout=new RegExp("^[0-9]{4}-[0-9]{2}-[0-9]{2}$")
                                            if(time_layout.test($("#starttime").val())&&time_layout.test($("#stoptime").val())){
                                                    return true;
                                            }else{
                                                    layer.msg("请按正确格式填写：xxxx-xx-xx", {icon: 5});
                                                    return false;
                                            }
                                        }
                                    </script>
                                </label>
                            </form>
                            </div>
                            </div>
                            <hr/>
                        </div>
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th><span class="glyphicon glyphicon-align-left"></span>时间</th>
                                <th><span class="glyphicon glyphicon-th-large"></span>物品</th>
                                <th><span class="glyphicon glyphicon-paperclip"></span>单位</th>
                                <th><span class="glyphicon glyphicon-edit"></span>总量</th>
                                <th><span class="glyphicon glyphicon-home"></span>入库量</th>
                                <th><span class="glyphicon glyphicon-home"></span>出库量</th>
                                <th><span class="glyphicon glyphicon-home"></span>现有</th>
                                <th><span class="glyphicon glyphicon-user"></span>记账人员</th>
                                <th><span class="glyphicon glyphicon-user"></span>记物人员</th>
                                <th><span class="glyphicon glyphicon-user"></span>领用人</th>
                                <th><span class="glyphicon glyphicon-user"></span>使用监督人</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($DangerData as $data)
                                <tr>
                                    <td>{{$data->log_time}}</td>
                                    <td>{{$data->log_goods_name}}</td>
                                    <td>{{$data->log_goods_units}}</td>
                                    <td>{{$data->log_goods_all}}</td>
                                    <td>{{$data->log_goods_in}}</td>
                                    <td>{{$data->log_goods_out}}</td>
                                    <td>{{$data->log_goods_now}}</td>
                                    {{--<td>{{$log_account_master[0]->user_name}}</td>--}}
                                    {{--<td>{{$log_mcmater_master[1]->user_name}}</td>--}}
                                    {{--<td>{{$log_user[0]->user_name}}</td>--}}
                                    {{--<td>{{$log_use_master[0]->user_name}}</td>--}}

                                    <td>{{$data->log_account_master}}</td>
                                    <td>{{$data->log_mcmater_master}}</td>
                                    <td>{{$data->log_user}}</td>
                                    <td>{{$data->log_use_master}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                            </div>
                        <div class="list">
                            {!! $DangerData->appends(["KS_select"=>$KSclass["KS_select"]])->appends(["desc"=>$desc['desc']])->links() !!}
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
</body>
</html>
