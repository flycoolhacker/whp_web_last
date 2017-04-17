<?php
header("Cache-Control: no-cache, must-revalidate");
header("Pramga: no-cache");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="ie-stand">
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap-theme.min.css')}}">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{asset('js/jquery.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
</head>
<body>
<div class="modal fade" id="SecondAdminLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">总管理员登陆</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                        <input class="form-control" type="text" id="user-text" placeholder="请输入您的ID" required autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                        <input class="form-control " type="password" id="user-pass" placeholder="请输入您的密码" required autofocus>
                    </div>
                </div>
                <p class="text-center" id="Lg-dialog"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary" id="btn-SecondAdminLogin">登陆</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ClassesAdminLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">科室管理员登陆</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                        <input class="form-control" type="text" id="user-text" placeholder="请输入您的ID" required autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                        <input class="form-control " type="password" id="user-pass" placeholder="请输入您的密码" required autofocus>
                    </div>
                </div>
                <p class="text-center" id="Lg-dialog"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary" id="btn-login">登陆</button>
            </div>
        </div>
    </div>
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
                    @section('tit_bla')

                        @show
                </ul>
            </div>
        </div>
    </nav>
</div>
@yield('content')
<script language="javascript">
    $('#btn-SecondAdminLogin').click(function(){
        $data={
            '_token': '{{csrf_token()}}',
            'username': $('#user-text').val(),
            'userpass': $('#user-pass').val(),
        };
        var url='SecondAdminLogin';
        $.post(url,$data,function(data){
            if(data.status==1){
                $('#Lg-dialog')[0].innerText=data.msg+"--3秒后跳转";
                $('#Lg-dialog').addClass('bg-success');
                setTimeout("window.location.href='admin'",3000);
            }else if(data.status==2){
                $('#Lg-dialog')[0].innerText=data.msg;
                $('#Lg-dialog').addClass('bg-danger');
            }else{
                $('#Lg-dialog')[0].innerText=data.msg;
                $('#Lg-dialog').addClass('bg-danger');
            }
        },'json')
    });

</script>
</body>
</html>
