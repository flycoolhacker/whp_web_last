<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap-theme.min.css')}}">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{asset('js/jquery.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
</head>
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
                <a href="" class="navbar-brand">实验物品辅助管理系统（顶级管理）</a>
            </div>
            <div class="collapse navbar-collapse navbar-responsive-collapse pull-right">
                <ul class="nav navbar-nav">
                    <li><a href="/company">单位管理</a></li>
                    <li class="active"><a href="/secondAdmin">管理员管理</a></li>
                    <li><img class="img-circle" src="img/bg1.jpg" style="height:50px;width:50px;margin-left:10px;"></li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<div class="con-body">
    <div style="height:100%;width:100%;z-index:-10;position:fixed;">
        <img style="height:100%;width:100%" src="img/bg1.jpg">
    </div>
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
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-10" >
                <div class="panel panel-default">
                    <div class="panel-body" >
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th><span class="glyphicon glyphicon-list-alt">ID</span></th>
                                <th><span class="glyphicon glyphicon-list-alt">负责人</span></th>
                                <th><span class="glyphicon glyphicon-list-alt">单位</span></th>
                                <th><span class="glyphicon glyphicon-map-marker"></span>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($adminData as $data)
                                <tr>
                                    <td style="">{{$data->admin_second_ids}}</td>
                                    <td style="">{{$data->admin_second_name}}</td>
                                    <td style="">{{$data->company_name}}</td>
                                    <td><button type="button" onclick="AdminDelete({{$data->admin_second_id}})" class="btn btn-block btn-danger btn-xs">删除</button>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-2" >
                <div class="panel panel-default">
                    <div class="panel-body" >
                        <ul class="nav nav-sidebar nav-pills nav-stacked" style="background-color: #F5F5F5;">
                            <br>
                            <button type="button" class="btn btn-primary btn-block btn-sm" data-toggle="modal" data-target="#addAdmin">添加负责人</button>
                            <br>
                            <div class="modal fade" id="addAdmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title" id="myModalLabel">添加负责人</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="/secondAdmin" method="post">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                登录ID：
                                                <input type="number"  name="admin_second_ids" class="form-control" placeholder="ID"  required autofocus><br>
                                                单位负责人：
                                                <input type="text"  name="admin_second_name" class="form-control" placeholder="负责人"  required autofocus><br>
                                                所属单位：
                                                <select class="form-control" name="admin_second_company" value="gtxittan" >
                                                    @foreach ($companyData as $value)
                                                        <option value="{{$value->company_id}}">{{$value->company_name}}</option>
                                                    @endforeach
                                                </select><br>
                                                登录密码：<br>
                                                <h4>默认为123456</h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">添加</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">返回</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    function AdminDelete(id){
        layer.confirm('确定删除？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post('secondAdmin/'+id,{'_method':'delete','_token':'{{csrf_token()}}'},function(data){
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

</html>

