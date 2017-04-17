@extends('layout.main')
@section('tit_bla')
    @parent
    <li><a href="/admin">物资</a></li>
    <li class="active"><a href="/secondAdmins">人员</a></li>
    <li><a href="/classes">科室管理</a></li>
    <li><a href="/dangernews">日志</a></li>
    <li><a href="" data-toggle="modal" data-target="#change" style="color: orange">修改密码</a></li>
    <li><a href="/logout" style="color: red">退出</a></li>
@endsection
@section('content')
    <div style="height:100%;width:100%;z-index:-10;position:fixed;">
        <img style="height:100%;width:100%" src="img/bg1.jpg">
    </div>
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
    <div class="con-body">
                <!-- Modal -->
                <div class="modal fade" id="change" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">修改当前管理员密码</h4>
                            </div>
                            <div class="modal-body">
                                <form action="/changepassword" method="post">
                                    密码：
                                    <input type="password"  name="admin_second_password" class="form-control" placeholder="Password"  required autofocus>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button type="submit" class="btn btn-warning">修改</button></form>
                            </div>
                        </div>
                    </div>
                </div>
        <div class="container">
            <div class="row">
                {{--左侧导航--}}
                <div class="col-sm-2 ">

                    {{--<ul class="nav nav-sidebar nav-pills nav-stacked" style="background-color: #F5F5F5;">--}}
                        {{--<li class="active"><a><h4>管理类别选择</h4></a></li>--}}
                        {{--<li class="active"><a href="/person">单位人员管理</a></li>--}}
                        {{--<li><a href="/classes">科室管理</a></li>--}}
                    {{--</ul>--}}

                    <ul class="nav nav-sidebar nav-pills nav-stacked" style="background-color: #F5F5F5;">
                        <li class="active"><a><h4>科室管理员搜索</h4></a></li>
                        <br>
                        <form action="/secondAdmins" method="get">
                            <input type="hidden" name="admin_classes_classes" value="{{$now_classes}}">
                            <input type="text"  name="admin_classes_name" class="form-control" placeholder="姓名" required autofocus>
                            <br>
                            <button id="SC_submit" class="btn btn-primary btn-block" type="submit">搜索</button>
                  
                        </form>
                    </ul>
                </div>


                <style type="text/css">
                    /* Sidebar navigation */
                    .nav-sidebar {
                        margin-right: -21px; /* 20px padding + 1px border */
                        margin-bottom: 20px;
                        margin-left: -20px;

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
                                <li><a href="javascript:;">科室管理员管理</a></li>
                            </ol>
                            <h4>
                                <div class="modal fade" id="addperson" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                <h4 class="modal-title" id="myModalLabel">添加人员</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p id="info_add_val" style="text-align: center;color:red;"></p>
                                                <form id="user_form" action="/secondAdmins" method="post">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
														<!--科室：<input class="form-control" id="add_classes_classes" name="admin_classes_classes" placeholder="请接入终端" value="" readonly><br>-->
                                                    科室：<select id="add_classes_classes" name="admin_classes_classes" class="form-control">
													      
													      </select><br>
													
												    卡ID: <input type="text"  id="add_classes_id" name="admin_classes_ids" class="form-control" value="" placeholder="等待终端刷卡" required autofocus readonly><br>
                                                    账号：<input type="text"  id="admin_classes_ides" name="admin_classes_ides" class="form-control" placeholder="用于登录的账号" onblur=judgeId("admin_classes_ides","add_submit") required autofocus><br>
                                                    工牌：<input type="text"  id="admin_classes_num" name="admin_classes_num" class="form-control" placeholder="工牌" required autofocus><br>
                                                    姓名：<input type="text"  id="admin_classes_name" name="admin_classes_name" class="form-control" placeholder="姓名" required autofocus><br>
                                                    性别：<select class="form-control" id="admin_classes_sex" name="admin_classes_sex" value="gtxittan" >
                                                        @foreach ($SexData as $value)
                                                            <option value="{{$value->sex_name}}">{{$value->sex_name}}</option>
                                                        @endforeach
                                                    </select><br>
                                                    人员属性：<select class="form-control" id="admin_classes_job" name="admin_classes_job" value="gtxittan" >
                                                        @foreach ($JobData as $value)
                                                            <option value="{{$value->job_name}}">{{$value->job_name}}</option>
                                                        @endforeach
                                                    </select><br>
                                                    人员类别：<select class="form-control" id="admin_classes_class" name="admin_classes_class" value="gtxittan" >
                                                        @foreach ($ClassData as $value)
                                                            <option value="{{$value->person_class_name}}">{{$value->person_class_name}}</option>
                                                        @endforeach
                                                    </select><br>
                                                    电话：<input type="number"  id="admin_classes_phone" name="admin_classes_phone" class="form-control" placeholder="电话" required autofocus><br>
                                                    备注：<input type="text"  id="admin_classes_add" name="admin_classes_add" class="form-control" placeholder="备注" required autofocus><br>
                                                    管理员登录密码：<br>
                                                    <h4>默认为123456</h4>
                                                    <div class="modal-footer">
                                                        <button type="button" onclick=getval("add_classes_id","getCardid","info_add_val","add_submit") class="btn btn-primary" >获取卡ID</button>
                                                        <button type="button" id="add_submit" onclick='return add_user("info_add_val")' class="btn btn-primary"  disabled="disable">添加</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">返回</button>
                                            </div>
                                                </form>
                                        </div>
                                    </div>
                                </div>
                            </h4>
                            <div class="row">
                                <div class="col-md-4">
                                <form action="/secondAdmins" method="get" class="form-inline" role="form">
                                    <select class="form-control" name="admin_classes_classes">
                                        <option value="">全部科室</option>
                                        @foreach($ClassesData as $value)
                                            <option @if($value->classes_id==$now_classes)
                                                    selected
                                                    @endif
                                                    value={{$value->classes_id}}>{{$value->classes_name}}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary pull-right">查看</button>
                                </form>
                                </div>
                                <div class="col-md-6">
                                    <form action="/PeoExcleShow" method="get">
                                        <input type="hidden" name="admin_classes_classes" value="{{$now_classes}}">
                                        <button type="submit" class="btn btn-info">导出人员</button>
                                    </form>
                                </div>
                                <div class="col-md-2">
                                <button class="btn btn-primary  " onclick=getval("add_classes_id","get_terminal_list","info_add_val","add_submit") data-toggle="modal" data-target="#addperson">添加人员</button>
                                </div>
                            </div>
                            <hr>
                            <div class="table-responsive">
                            <table class="table table-bordered table-responsive table-striped table-hover">
                                <thead>
                                <tr>
                                    <th><span class="glyphicon glyphicon-text-width"></span>工牌</th>
                                    <th><span class="glyphicon glyphicon-user"></span>姓名</th>
                                    <th><span class="glyphicon glyphicon-heart"></span>性别</th>
                                    <th><span class="glyphicon glyphicon-home"></span>科室</th>
                                    <th><span class="glyphicon glyphicon-edit"></span>人员属性</th>
                                    <th><span class="glyphicon glyphicon-stats"></span>人员类别</th>
                                    <th><span class="glyphicon glyphicon-phone"></span>电话</th>
                                    <th><span class="glyphicon glyphicon-pencil"></span>备注</th>
                                    <th  style="width:93px;"><span class="glyphicon glyphicon-map-marker"></span>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($SecondAdminData as $data)
                                    <tr>
                                        <td>{{$data->admin_classes_num}}</td>
                                        <td>{{$data->admin_classes_name}}</td>
                                        <td>{{$data->admin_classes_sex}}</td>
                                        <td>{{$data->classes_name}}</td>
                                        <td>{{$data->admin_classes_job}}</td>
                                        <td>{{$data->admin_classes_class}}</td>
                                        <td>{{$data->admin_classes_phone}}</td>
                                        <td>{{$data->admin_classes_add}}</td>
                                        <td><!-- Button trigger modal -->
                                            <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#moreclassesAdmin{{$data->admin_classes_id}}">
                                                编辑
                                            </button>
                                            <button type="button" onclick="return SecondAdminDelete('{{$data->admin_classes_ids}}','{{$data->admin_classes_classes}}');" class="btn btn-danger btn-xs">删除</button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="moreclassesAdmin{{$data->admin_classes_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">当前人员：{{$data->admin_classes_name}}</h4>
                                                        </div>
                                                        <form action="{{url('/secondAdmins/'.$data->admin_classes_ids)}}" id="up_url{{$data->admin_classes_id}}" method="post">
                                                        <div class="modal-body">
                                                                <input type="hidden" name="_method" value="put">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <input type="hidden" name="admin_classes_id" value="{{$data->admin_classes_id}}">
                                                                <input type="hidden" name="admin_classes_company" value="{{$data->admin_classes_company}}">
                                                                <p id="info_up_val{{$data->admin_classes_id}}" style="text-align: center;color:red;"></p>
                                                                <input type="hidden" name="admin_classes_classes" value="{{$data->admin_classes_classes}}">
                                                                <input type="hidden" id="ids_id{{$data->admin_classes_id}}" value="{{$data->admin_classes_ids}}">
                                                                卡ID：<input type="text"  id="up_classes_ids{{$data->admin_classes_id}}" name="admin_classes_ids" class="form-control" placeholder="等待终端刷卡" value="{{$data->admin_classes_ids}}" required autofocus readonly><br>
                                                                账号：<input type="text"  id="up_classes_ides{{$data->admin_classes_id}}" name="admin_classes_ides" class="form-control" placeholder="用于登录的账号" value="{{$data->admin_classes_ides}}" onblur=judgeId("up_classes_ides{{$data->admin_classes_id}}","up_submit{{$data->admin_classes_id}}",1,"{{$data->admin_classes_id}}") required autofocus ><br>
                                                                工牌：<input type="text"  id="up_classes_num{{$data->admin_classes_id}}" name="admin_classes_num" class="form-control" placeholder="工牌" value="{{$data->admin_classes_num}}" required autofocus ><br>
                                                                姓名：<input type="text"  id="up_classes_name{{$data->admin_classes_id}}" name="admin_classes_name" class="form-control" placeholder="姓名" value="{{$data->admin_classes_name}}" required autofocus><br>
                                                                性别：<select id="up_classes_sex{{$data->admin_classes_id}}" class="form-control" name="admin_classes_sex" value="{{$data->admin_classes_sex}}" >
                                                                @foreach ($SexData as $value)
                                                                    <option @if(strcmp($data->admin_classes_sex,$value->sex_name)==0)
                                                                            selected
                                                                            @endif value="{{$value->sex_name}}">{{$value->sex_name}}</option>
                                                                @endforeach
                                                            </select><br>
                                                                人员类别：<select id="up_classes_class{{$data->admin_classes_id}}" class="form-control" name="admin_classes_class" value="{{$data->admin_classes_class}}" >
                                                                @foreach ($ClassData as $value)
                                                                    <option @if(strcmp($data->admin_classes_class,$value->person_class_name)==0)
                                                                            selected
                                                                            @endif value="{{$value->person_class_name}}">{{$value->person_class_name}}</option>
                                                                @endforeach
                                                            </select><br>
                                                                人员属性：<select id="up_classes_job{{$data->admin_classes_id}}" class="form-control" name="admin_classes_job" value="{{$data->admin_classes_job}}" >
                                                                    @foreach ($JobData as $value)
                                                                        <option @if(strcmp($data->admin_classes_job,$value->job_name)==0)
                                                                                selected
                                                                                @endif value="{{$value->job_name}}">{{$value->job_name}}</option>
                                                                    @endforeach
                                                                </select><br>
                                                                电话：<input type="text"  id="up_classes_phone{{$data->admin_classes_id}}" name="admin_classes_phone" class="form-control" placeholder="电话" value="{{$data->admin_classes_phone}}" required autofocus ><br>
                                                                备注：<input type="text"  id="up_classes_add{{$data->admin_classes_id}}" name="admin_classes_add" class="form-control" placeholder="备注" value="{{$data->admin_classes_add}}" required autofocus ><br>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" onclick=getval("up_classes_ids"+{{$data->admin_classes_id}},"getCardid","info_up_val"+{{$data->admin_classes_id}},"up_submit"+{{$data->admin_classes_id}},{{$data->admin_classes_classes}}) class="btn btn-primary" >获取卡ID</button>
                                                            <button type="button" id="up_submit{{$data->admin_classes_id}}" onclick='return up_user({{$data->admin_classes_classes}},"ids_id"+{{$data->admin_classes_id}},"up_url"+{{$data->admin_classes_id}},"info_up_val"+{{$data->admin_classes_id}},"up_classes_ides"+{{$data->admin_classes_id}},
                                                                    "up_classes_ids"+{{$data->admin_classes_id}},"up_classes_num"+{{$data->admin_classes_id}},"up_classes_name"+{{$data->admin_classes_id}},
                                                                    "up_classes_sex"+{{$data->admin_classes_id}},"up_classes_class"+{{$data->admin_classes_id}},"up_classes_job"+{{$data->admin_classes_id}},
                                                                    "up_classes_phone"+{{$data->admin_classes_id}},"up_classes_add"+{{$data->admin_classes_id}});' class="btn btn-warning">修改</button>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">返回</button>
                                                        </div>
                                                        </form>
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
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('layer/layer.js')}}"></script>
    <script language="javascript">
        //删除
        function del_user(id,ids){
            var url="http://120.76.245.91:888/hou/httpHandler.do";
            var info="DELETE FROM `new_whp`.`admin_classes` WHERE `admin_classes_ids`=?;:"+id;
            var data={"bag_id":"updateSql","info":info,"terminal_id":ids};
            $.ajax({
                        type:"post",
                        async: false,
                        url:"http://120.76.245.91:888/hou/httpHandler.do",
                        dataType: "jsonp",
                        jsonp: "mugui",
                        jsonpCallback:"end",
                        data:data,
                        cache:false,
                        success: function(json){
                            var bag_id=json.bag_id;
                            if(bag_id=="updateSql"){
                                $.post('secondAdmins/'+id,{'_method':'delete','_token':'{{csrf_token()}}'},function(data){
                                    if(data.status==1){
                                        layer.msg(data.message, {icon: 6});
                                        location.href=location.href;
                                    }else{
                                        layer.msg(data.message, {icon: 5});
                                    }
                                },"json")
                            }else if(bag_id=="error"){
                                layer.msg(json.info, {icon: 5});
                            }
                        },
                        error: function() {
                            layer.msg("请检查终端是否有反应，刷卡是否正确！", {icon: 5});
                        }
                    }
            );
            return true;
        }
        function SecondAdminDelete(id,ids){
            layer.confirm('确定删除？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                del_user(id,ids);
            }, function(){
            });
        }
        //判断终端有没有该卡ID
        function judge_ids(id,info_id,sumbit_id,ids){
			if(ids){
				
			}else{
			var t = document.getElementById("add_classes_classes");
			var ids=t.options[t.selectedIndex].value;
			}
			var data={"bag_id":"judge_id","info":id,"terminal_id":ids};
            $.ajax({
                        type:"post",
                        async: false,
                        url:"http://120.76.245.91:888/hou/httpHandler.do",
                        dataType: "jsonp",
                        jsonp: "mugui",
                        jsonpCallback:"end",
                        data:data,
                        cache:false,
                        success: function(json){
                            var bag_id=json.bag_id;
                            if(bag_id=="judge_id"){
                                document.getElementById(info_id).innerText=json.info;
                                $("#"+sumbit_id).removeAttr("disabled");
                            }else if(bag_id=="error"){
                                document.getElementById(info_id).innerText=json.info;
                                $("#"+sumbit_id).attr("disabled","disabled");
                            }
                        },
                        error: function() {
                            layer.msg("请检查终端是否有反应，刷卡是否正确！", {icon: 5});
                        }
                    }
            );
        }
        //获取制作卡的ID并且判断终端有无此ID
        function getval(view_classes_id,bag_name,info_id,sumbit_id,ids){
			if(ids){
				
			}else{
			var t = document.getElementById("add_classes_classes");
			var ids=t.options[t.selectedIndex];
			if(ids===undefined){
					var ids="";
					var info={{session("now_company")}};
			}else{
				var ids=t.options[t.selectedIndex].value;
				var info={{session("now_company")}};
			}
			}
                $.ajax({
                            type:"get",
                            async: false,
                            url:"http://120.76.245.91:888/hou/httpHandler.do?bag_id="+bag_name+"&terminal_id="+ids+"&info="+info,
                            dataType: "jsonp",
                            jsonp: "mugui",
                            jsonpCallback:"end",
                            cache:false,
                            success: function(json){
                                var bag_id=json.bag_id;
                                if(bag_id=="get_terminal_list"){
									
                                  //  document.getElementById("add_classes_classes").value=json.info;
								  jsondata=json.info;
								  var str=jsondata.split("|");
								  $("#add_classes_classes").empty(); //清空select表
								  var obj=document.getElementById("add_classes_classes");
								  for(i=0;i<str.length-1;i++){
									  var str1=str[i].split("^");
									  obj.options.add(new Option(str1[1],str1[0]));
								  }
								  
                                }else if(bag_id=="error"){
                                    document.getElementById(info_id).innerText=json.info;
                                }else if(bag_id=="getCardid"){
                                    document.getElementById(view_classes_id).value=json.info;
                                    judge_ids(json.info,info_id,sumbit_id,ids);
                                }
                            },
                            error: function() {
                                layer.msg("请检查终端是否有反应，刷卡是否正确！", {icon: 5});
                            }
                        }
                );
        }

        //添加人员
        function add_user(info_id){
            if($("#add_classes_id").val()==""||$("#add_classes_classes").val()==""){
                $("#"+info_id).html("请连接终端和刷人员卡！");
                return false;
            }else{
				var ids=document.getElementById("add_classes_classes").value;
                var admin_classes_classes=$("#add_classes_classes").val();
                var admin_classes_ides=$("#admin_classes_ides").val();
                var admin_classes_num=$("#admin_classes_num").val();
                var admin_classes_name=$("#admin_classes_name").val();
                var admin_classes_sex=$("#admin_classes_sex option:selected").val();
                var admin_classes_job=$("#admin_classes_job option:selected").val();
                var admin_classes_class=$("#admin_classes_class option:selected").val();
                var admin_classes_phone=$("#admin_classes_phone").val();
                var admin_classes_add=$("#admin_classes_add").val();
                var admin_classes_password="{{md5("123456")}}";
                var admin_classes_company="{{session("now_company")}}";
                var admin_classes_ids=$("#add_classes_id").val();
                if(admin_classes_ides==""||admin_classes_num==""||admin_classes_name==""
                        ||admin_classes_phone==""||admin_classes_add==""){
                    document.getElementById(info_id).innerText="请检查输入内容！！！";
                }else{
                    var info="SET SQL_SAFE_UPDATES = 0;"
                            +"INSERT INTO `new_whp`.`admin_classes` (`admin_classes_ids`,`admin_classes_name`,`admin_classes_job`,`admin_classes_ides`,`admin_classes_num`,`admin_classes_class`,`admin_classes_phone`,`admin_classes_add`,`admin_classes_company`,`admin_classes_password`,`admin_classes_sex`) VALUES (?,?,?,?,?,?,?,?,?,?,?);"
                            +"update `new_whp`.`admin_classes` set `admin_classes_classes`=(SELECT classes_id FROM new_whp.classes where classes_name=?) where admin_classes_ids= ? ;"+":;"+admin_classes_ids+","+admin_classes_name+","+admin_classes_job+","+admin_classes_ides+","+admin_classes_num+","+admin_classes_class+","+admin_classes_phone+","+admin_classes_add+","+admin_classes_company+","+admin_classes_password+","+admin_classes_sex+";"+admin_classes_classes+","+admin_classes_ids;
                    var url="http://10.14.2.135/hou/httpHandler.do";
                    var data={"bag_id":"updateSql","info":info,"terminal_id":ids};
                    $.ajax({
                                type:"post",
                                async: false,
                                url:"http://120.76.245.91:888/hou/httpHandler.do",
                                dataType: "jsonp",
                                jsonp: "mugui",
                                jsonpCallback:"end",
                                data:data,
                                cache:false,
                                success: function(json){
                                    var bag_id=json.bag_id;
                                    if(bag_id=="updateSql"){
                                        $("#user_form").submit();
                                    }else if(bag_id=="error"){
                                        document.getElementById(info_id).innerText=json.info;
                                        //$("#user_form").submit();
                                        //证明终端上有卡号服务器上边没有。
                                        //给终端发送一个请求得到该卡号信息的请求，弹出对话框：检测终端上边该卡号
                                        //已被录入，可能因为其它原因服务器上边并没有该卡号数据
                                        //显示数据后询问是否添加上一次数据
                                    }
                                },
                                error: function() {
                                    layer.msg("请检查终端是否有反应，刷卡是否正确！", {icon: 5});
                                }
                            }
                    );
                }
                return false;
            }
        }

        //跟新人员
        function up_user(ids,ids_id,form_id,info_id,up_ides_id,up_ids_id,up_num_id,up_name_id,up_sex_id,up_class_id,up_job_id,up_phone_id,up_add_id){
            if($("#"+up_ids_id).val()==""){
                $("#"+info_id).html("请连接终端和刷人员卡！");
                return false;
            }else{
                var admin_classes_name=$("#"+up_name_id).val();
               // var admin_classes_password="{{md5("123456")}}";
                var admin_classes_job=$("#"+up_job_id+" option:selected").val();
                var admin_classes_ides=$("#"+up_ides_id).val();
                var admin_classes_num=$("#"+up_num_id).val();
                var admin_classes_name=$("#"+up_name_id).val();
                var admin_classes_sex=$("#"+up_sex_id+" option:selected").val();
                var admin_classes_class=$("#"+up_class_id+" option:selected").val();
                var admin_classes_phone=$("#"+up_phone_id).val();
                var admin_classes_add=$("#"+up_add_id).val();
                var admin_classes_ids=$("#"+up_ids_id).val();
                var info="UPDATE `new_whp`.`admin_classes` SET `admin_classes_name`=?, `admin_classes_sex`=?, `admin_classes_class`=?, `admin_classes_phone`=?, `admin_classes_job`=?, `admin_classes_add`=?,"
                 +"`admin_classes_ids`=?, `admin_classes_num`=?,"
                  +"`admin_classes_ides`=? WHERE `admin_classes_ids`=?;:"+admin_classes_name+","+admin_classes_sex+","+admin_classes_class+","+admin_classes_phone+","+admin_classes_job+","+admin_classes_add+","+admin_classes_ids+","+admin_classes_num+","+admin_classes_ides+","+admin_classes_ids;

                var data={"bag_id":"updateSql","info":info,"terminal_id":ids};
                $.ajax({
                            type:"post",
                            async: false,
                            url:"http://120.76.245.91:888/hou/httpHandler.do",
                            dataType: "jsonp",
                            jsonp: "mugui",
                            jsonpCallback:"end",
                            data:data,
                            cache:false,
                            success: function(json){
                                var bag_id=json.bag_id;
                                if(bag_id=="updateSql"){
                                    $("#"+form_id).submit();
                                }else if(bag_id=="error"){
                                    document.getElementById(info_id).innerText=json.info;
                                    //$("#user_form").submit();
                                    //证明终端上有卡号服务器上边没有。
                                    //给终端发送一个请求得到该卡号信息的请求，弹出对话框：检测终端上边该卡号
                                    //已被录入，可能因为其它原因服务器上边并没有该卡号数据
                                    //显示数据后询问是否添加上一次数据
                                }
                            },
                            error: function() {
                                layer.msg("请检查终端是否有反应，刷卡是否正确！", {icon: 5});
                            }
                        }
                );

                return false;
            }
            return false;
        }
		
		//判断用户登陆ID是否存在
		
		function judgeId(id,ids,sta,staId){
			var url="judgeId";
			if(sta){
				var data={
				"ides":$("#"+id).val(),
				"id":staId,
				"sta":sta,
				"_token":'{{csrf_token()}}',
			}
			}else{
				var data={
				"ides":$("#"+id).val(),
				"_token":'{{csrf_token()}}',
			}
			}
			$.post(url,data,function(data){
				if(data.status==1){
					layer.msg(data.msg, {icon: 5});
					$("#"+ids).attr("disabled","disabled");
				}else{
					$("#"+ids).removeAttr("disabled");
				}
			},"JSON");
		}
    </script>
@endsection