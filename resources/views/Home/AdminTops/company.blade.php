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
                    <li class="active"><a href="/company">单位管理</a></li>
                    <li><a href="/secondAdmin">管理员管理</a></li>
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
                                        <th><span class="glyphicon glyphicon-list-alt">单位</span></th>
                                        <th><span class="glyphicon glyphicon-map-marker"></span>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($companyData as $data)
                                        <tr>
                                            <td style="width:710px;">{{$data->company_name}}</td>
                                            <td><button type="button" class="btn btn-block btn-danger btn-xs" data-toggle="modal" data-target="#delete_{{$data->company_id}}">删除</button>
                                                <div class="modal fade" id="delete_{{$data->company_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title" id="myModalLabel">警告！</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h4>警告！这将删除掉该单位的所有数据！确定删除！？</h4>
                                                                <br>
                                                                <form method="get" action="{{url('/delete/'.$data->company_id)}}">
                                                                <input type="text"  name="think" class="form-control" placeholder="输入我要删除"  required autofocus><br>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button  type="submit"  class="btn btn-danger" name="delete" >删除</button></form>
                                                                <!--<a href="{{url('/delete/'.$data->company_id)}}" type="submit"  class="btn btn-danger" name="delete" >删除</a></form>-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
                                    <button type="button" class="btn btn-primary btn-block btn-sm" data-toggle="modal" data-target="#addCompany">添加单位</button>
                                    <br>
                                    <div class="modal fade" id="addCompany" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">添加单位</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="/company" method="post">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="number"  name="company_id" class="form-control" placeholder="单位编号"  required autofocus><br>
                                                        <input type="text"  name="company_name" class="form-control" placeholder="单位"  required autofocus><br>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">添加</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">返回</button>
                                                    </form>
                                                </div>
                                        </div>
                                    </div>
                                    <br>
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
    function CompanyDelete(id){
        layer.confirm('警告！这将删除掉该单位的所有数据！确定删除？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post('company/'+id,{'_method':'delete','_token':'{{csrf_token()}}'},function(data){
                if(data.status==1){
                    layer.msg(data.message, {icon: 6});
                    //location.href=location.href;
                }else{
                    layer.msg(data.message, {icon: 5});
                }
            },"json")
        }, function(){
        });
    }
</script>

</html>

