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
                <a href="javascript:;" class="navbar-brand">实验物品辅助管理系统</a>
            </div>
        </div>
    </nav>
</div>

    <div class="con-body">
        <div class="banner">
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
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2" style="height:731px;">
                        <body>
                        <div style="height:150px;"></div>
                        <p class="lead" style="font-size:65px;color:white;text-align:center;">化学材料管理</p>
                        <p class="lead" style="font-size:30px;color:white;text-align:center;">试剂 危化品 耗材 管理服务</p>
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h2 style="text-align:center">顶级管理员登陆</h2>
                                    <hr/>
                                    <form  method="post" action="/_adminTopLogin">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <div class="form-group">
                                            <label>ID号</label>
                                            <input type="number" class="form-control" name="admin_top_ids" placeholder="ID号">
                                        </div>
                                        <div class="form-group">
                                            <label>密码</label>
                                            <input type="password" class="form-control" name="admin_top_password" placeholder="密码 ">
                                        </div>
                                        <p class="text-center" id="Lg-dialog"></p>
                                            <button type="submit" class="btn btn-primary btn-block">登陆</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--内容部分结束--}}
    <div class="con-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div style="height:50px;"></div>
                    <p>地址：XXXXXXXX</p>
                    <p>联系电话：12345678</p>
                    <p>联系人：X先生</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

