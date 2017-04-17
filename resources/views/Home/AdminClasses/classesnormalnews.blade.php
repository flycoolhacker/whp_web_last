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
                <a href="#" class="navbar-brand">实验物品辅助管理系统</a>
            </div>
            <div class="collapse navbar-collapse navbar-responsive-collapse pull-right">
                <ul class="nav navbar-nav">
                    <li><a href="/classesadmin">物资</a></li>
                    <li><a href="/classesperson">人员</a></li>
                    <li  class="active"><a href="/classesdangernews">日志</a></li>
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
                    <li><a href="/classesdangernews">危化品</a></li>
                    <li class="active"><a href="/classesnormalnews">常规品</a></li>
                    <li class="active"><a><h4>领用人搜索</h4></a></li>
                    <br>
                    <form action="/searchClassesnormalPerson" method="get">
                        <input type="text"  name="log_user" class="form-control" placeholder="姓名" required autofocus>
                        <br>
                        <button  class="btn btn-primary btn-block" type="submit">搜索</button>
                    </form>
                </ul>
            </div>
            {{--右侧内容--}}
            <div class="col-md-10" >
                <div class="panel panel-default">
                    <div class="panel-body" >
                        <ol class="breadcrumb">
                            <li><a>首页</a></li>
                            <li><a>危化日志</a></li>
                        </ol>
                        <div class="form-inline" role="form">
                            <div class="row">
                             <div class="col-md-4">
                            <form action="/classesnormalnews" method="post">
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
                                </select>
                                <button class="btn btn-primary" type="submit">确认</button>
                                </form>
                             </div>
                            <div class="col-md-8">
                            <form action="logTimeShow" target="_blank" method="get" class="form-inline" role="form">
                                <label class="pull-right">
                                    <div class="form-group">
                                        <label class="sr-only" for="starttime">开始时间</label>
                                        <input type="text" name="starttime" id="starttime" class="form-control" placeholder="开始时间:2020-01-01" required>
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
                                        <input type="hidden" id="YP_type" value="2" name="YP_type">
                                    </div>
                                    <button class="btn btn-info btn-sm" type="submit">查看出入库记录表</button>
                                </label>
                            </form>
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
                                <th><span class="glyphicon glyphicon-user"></span>管理人员</th>
                                <th><span class="glyphicon glyphicon-user"></span>领用人</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($NormalData as $data)
                                <tr>
                                    <td>{{$data->log_time}}</td>
                                    <td>{{$data->log_goods_name}}</td>
                                    <td>{{$data->log_goods_units}}</td>
                                    <td>{{$data->log_goods_all}}</td>
                                    <td>{{$data->log_goods_in}}</td>
                                    <td>{{$data->log_goods_out}}</td>
                                    <td>{{$data->log_goods_now}}</td>
                                    <td>{{$data->log_use_master}}</td>
                                    <td>{{$data->log_user}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="list">
    
                        @if(isset($userName['log_user']))
                        {{$NormalData->appends(['desc'=>$desc['desc']])->appends(['log_user'=>$userName['log_user']])->links()}}
                        @else
                        {{$NormalData->appends(['desc'=>$desc['desc']])->links()}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{asset('js/jquery.js')}}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
</body>
</html>
