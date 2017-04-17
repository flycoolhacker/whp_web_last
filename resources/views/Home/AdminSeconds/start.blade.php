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
    <script src="{{asset('layer/layer.js')}}"></script>
</head>
<body>
<div style="height:100%;width:100%;position:fixed;z-index: -20">
    <img src="img/banners.jpg" style="height:100%;width:100%;">
</div>
<div class="container">
            <div class="row">
                <div style="height:80px;"></div>
               <div class="col-md-6 col-md-offset-3" style="border-radius:25px 25px 0 0;border:3px solid #385D8A;height:350px;">
               <div style="height:80px;background-color:#A6A6A6;border-radius:24px 24px 0 0;margin:0 -15px;">
                   <div style="height:10px;"></div>
                   <p style="font-family:隶书;color:#17375E;font-size:45px;text-align: center;">危险化学品管理系统</p>
               </div>
                   <div class="row">
                       <div class="pull-left col-md-4" style='height:265px;background-size:cover; background-image: url("../../img/left1.png")'>
                       </div>
                       <div class="pull-right col-md-8" style="background-color:#D9D9D9; height:265px;">
                           <div id="Admin1" style="">
                           <table>
                               <tr style="height:10px;"></tr>
                               <tr>
                                   <td colspan="2">
                                           <div class="col-md-6"  onclick="Admin1();" style="cursor:pointer;background-color:#95B3D7;font-size:18px;border:2px solid #7F7F7F;border-radius: 0 50% 0 0 ">科室管理员</div>
                                           <div class="col-md-5 col-md-offset-1"  onclick="Admin2();" style="cursor:pointer;font-size:18px;border:2px solid #7F7F7F;border-radius: 0 50% 0 0 ">总管理员</div>
                                   </td>
                               </tr>
                               <tr style="height:20px;"></tr>
                               <form action="/ClassesAdminLogin" method="post">
                               <tr>
                                   <td style="font-size: 20px;color:red" colspan="2">账号</td>
                               </tr>
                               <tr style="height:10px;"></tr>
                               <tr>
                                   <td>
                                       <input type="text"  id="readonly" name="admin_classes_ides" class="form-control"  placeholder="账号"  >
                                   </td>
                                   <!--<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-warning" id="content">连接机器</button></td>-->
                               </tr>
                               <tr style="height:10px;"></tr>
                               <tr>
                                   <td  style="font-size: 20px;color:red" colspan="2">登陆密码</td>
                               </tr>
                               <tr style="height:10px;"></tr>
                               <tr>
                                   <td>
                                       <input type="password"  name="admin_classes_password" class="form-control" placeholder="Password"  required autofocus>
                                   </td>
                                   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary" id="login_but" >登录系统</button></td>
                               </tr>
                               </form>
                           </table>
                           </div>
                           <div id="Admin2" style="display: none">
                               <table>
                                   <tr style="height:10px;"></tr>
                                   <tr>
                                       <td colspan="2">
                                           <div class="col-md-6"  onclick="Admin1();" style="cursor:pointer;font-size:18px;border:2px solid #7F7F7F;border-radius: 0 50% 0 0 ">科室管理员</div>
                                           <div class="col-md-5 col-md-offset-1"  onclick="Admin2();" style="cursor:pointer;background-color:#95B3D7;font-size:18px;border:2px solid #7F7F7F;border-radius: 0 50% 0 0 ">总管理员</div>
                                       </td>
                                   </tr>
                                   <tr style="height:20px;"></tr>
                                   <form action="/SecondAdminLogin" method="post">
                                       <tr>
                                           <td style="font-size: 20px;color:red" colspan="2">账号</td>
                                       </tr>
                                       <tr style="height:10px;"></tr>
                                       <tr>
                                           <td>
                                               <input type="number"  name="admin_second_ids" class="form-control" placeholder="账号"  required autofocus>
                                           </td>
                                       </tr>
                                       <tr style="height:10px;"></tr>
                                       <tr>
                                           <td  style="font-size: 20px;color:red" colspan="2">登陆密码</td>
                                       </tr>
                                       <tr style="height:10px;"></tr>
                                       <tr>
                                           <td>
                                               <input type="password"  name="admin_second_password" class="form-control" placeholder="Password"  required autofocus>
                                           </td>
                                           <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary">登录系统</button></td>
                                       </tr>
                                   </form>
                               </table>
                           </div>
                       </div>
                   </div>
               </div>
            </div>
            <div class="row">
                <div style="height:100px;"></div>
                <div class="col-md-8 col-md-offset-2">
                    <p class="lead" style="color:black;text-align:center;">技术支持：成都迈达斯医药科技有限公司</p>
                    <p class="lead" style="color:black;text-align:center;">客服电话：8866XXXX        Email: mdsyy@163.com</p>
                </div>
            </div>
</div>
</body>
{{--内容部分结束--}}
<script type="text/javascript">
    $('#content').click(function(){
        $.ajax({
            type:"get",
            async: false,
            url:"http://120.76.245.91:888/hou/httpHandler.do?bag_id=getCardid&info=&math_id=",
            dataType: "jsonp",
            jsonp: "mugui",
            jsonpCallback:"end",
                    cache:false,
            success: function(json){
                 var bag_id=json.bag_id;
                 if(bag_id=="getCardid"){
                     $("#login_but").removeAttr('disabled');
                     document.getElementById("readonly").value=json.info;
                 }else if(bag_id=="error"){
                     layer.msg(json.info, {icon: 5});
                 }
            },
            error: function() {
                layer.msg("终端传输失败，请重新操作", {icon: 5});
            }
        }
        );
    })

    function Admin1(){
        $("#Admin1").css("display","block");
        $("#Admin2").css("display","none");
    }
    function Admin2(){
        $("#Admin2").css("display","block");
        $("#Admin1").css("display","none");
    }
</script>
