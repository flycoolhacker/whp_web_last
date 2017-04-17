<!DOCTYPE html>
<html lang="en" xmlns:http="http://www.w3.org/1999/xhtml">
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
    <style type="text/css">
        #top_top{
            z-index:10;
            background-color: black;
            width:100%;
            height:100%;
            position: fixed;
            filter:alpha(opacity=50); /*IE滤镜，透明度50%*/
            -moz-opacity:0.5; /*Firefox私有，透明度50%*/
            opacity:0.5;/*其他，透明度50%*/
        }
        #top{
            height:250px;
            width:550px;
            margin:0 auto;
            margin-top:150px;
        }
        #top p{
            font-size:30px;
            color:white;
            filter:alpha(opacity=100); /*IE滤镜，透明度50%*/
            -moz-opacity:1; /*Firefox私有，透明度50%*/
            opacity:1;/*其他，透明度50%*/
        }
    </style>
</head>
<body >
<div id="top_top">
    <div id="top">
        <p>本系统暂不支持360等三核以上浏览器</p>
        <p>若擅自使用，所做造成的一切后果自行承担！！！</p>
        <p style="float: right;"><a href="/start" style="color:white">同意使用</a></p>
    </div>
</div>
<div class="con-header">
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="xx" class="navbar-brand">xx化学管理</a>
            </div>
            <div class="collapse navbar-collapse navbar-responsive-collapse pull-right">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="{{url('/')}}">首页</a></li>
                    <li><a href="javascript:;" data-toggle="modal" data-target="#SecondAdminLogin" >总管理员登陆</a></li>
                    <li><a href="javascript:;" data-toggle="modal" data-target="#ClassesAdminLogin">科室管理员登陆</a></li>
                </ul>
            </div>

        </div>
    </nav>
</div>

<div class="modal fade" id="SecondAdminLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">总管理员登录</h4>
            </div>
            <div class="modal-body">
                <form action="/SecondAdminLogin" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    登录ID：
                    <input type="number"  name="admin_second_ids" class="form-control" placeholder="ID"  required autofocus><br>
                    密码：
                    <input type="password"  name="admin_second_password" class="form-control" placeholder="Password"  required autofocus>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">登录</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">返回</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ClassesAdminLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel" >  科室管理员登录</h4>
            </div>
            <div class="modal-body">
                <form action="/ClassesAdminLogin" method="post">
                    <p id="info_val"></p>
                    登录ID：
                    <input type="text"  id="readonly" name="admin_classes_ids" class="form-control"  placeholder="" value="1"  readonly ><br>
                    密码：
                    <input type="password"  name="admin_classes_password" class="form-control" placeholder="Password"  required autofocus>
            </div>
            <p class="text-center" id="test"></p>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">返回</button>
                <button type="submit" class="btn btn-primary" id="login_but" disabled="disabled">登录</button></form>
                <input type="hidden"  id="info" value="hello world!"  onblur="">
                <button type="button" class="btn btn-warning" id="content">连接机器</button>
            </div>
        </div>
    </div>
</div>

<div class="con-body1">
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
                <div class="col-md-8 col-md-offset-2" style="height:734px;">
                    <div style="height:200px;"></div>
                    <p class="lead" style="font-size:65px;color:white;text-align:center;">化学材料管理</p>
                    <p class="lead" style="font-size:30px;color:white;text-align:center;">试剂 危化品 耗材 管理服务</p>
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
                <p>地址：XXXXXXX</p>
                <p>联系电话：12345678</p>
                <p>联系人：XXX</p>
            </div>
        </div>
    </div>
</div>
</body>

