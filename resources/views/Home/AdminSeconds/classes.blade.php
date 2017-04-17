@extends('layout.main')
@section('tit_bla')
    @parent
    <li><a href="/admin">物资</a></li>
    <li><a href="/secondAdmins">人员</a></li>
    <li class="active"><a href="/classes">科室管理</a></li>
    <li><a href="/dangernews">日志</a></li>
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
        
        <div class="container">
            <div class="row">
                {{--左侧导航--}}
                <div class="col-sm-2 ">
                    <ul class="nav nav-sidebar nav-pills nav-stacked" style="background-color: #F5F5F5;">
                        <li class="active"><a><h4>操作</h4></a></li>
                        <br>
                        <button class="btn btn-primary btn-block " data-toggle="modal" data-target="#addclasses">添加科室</button>
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
                                <li><a href="/admin">物资</a></li>
                                <li><a href="/classes">科室管理</a></li>
                            </ol>
                            <h4>
                                <div class="modal fade" id="addclasses" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                <h4 class="modal-title" id="myModalLabel">添加科室</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/classes" method="post">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="text"  name="classes_name" class="form-control" placeholder="科室名称" required autofocus><br>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary" >添加</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">返回</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </h4>
                            <hr>
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th><span class="glyphicon glyphicon-home"></span>科室</th>
                                    <th  style="width:93px;"><span class="glyphicon glyphicon-map-marker"></span>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($classesData as $data)
                                    <tr>
                                        <td>{{$data->classes_name}}</td>

                                        <td><!-- Button trigger modal -->
                                            <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#moreclasses{{$data->classes_id}}">
                                                编辑
                                            </button>
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete{{$data->classes_id}}">删除</button>

											<!-- Modal -->
											<div class="modal fade" id="delete{{$data->classes_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											  <div class="modal-dialog">
											    <div class="modal-content">
											      <div class="modal-header">
											        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											        <h4 class="modal-title" id="myModalLabel">警告！</h4>
											      </div>
											      <div class="modal-body">
											      	<h3>当前科室：{{$data->classes_name}}</h3>
											      	<br>
											        <h4>这将删除该科室有关的所有人员和物品！</h4>
											      </div>
											      <div class="modal-footer">
											        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
											        <button type="button" onclick="Classes_Del({{$data->classes_id}})" class="btn btn-danger">删除</button>
											      </div>
											    </div>
											  </div>
											</div>

                                            <!--<button type="button" onclick="Classes_Del({{$data->classes_id}})" class="btn btn-danger btn-xs">删除</button>-->
                                            <!-- Modal -->
                                            <div class="modal fade" id="moreclasses{{$data->classes_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">当前科室：{{$data->classes_name}}</h4>
															<input type="hidden" id="classid{{$data->classes_id}}" value="{{$data->classes_id}}">
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{url('/classes/'.$data->classes_id)}}" id="form_id{{$data->classes_id}}" method="post">
                                                                <input type="hidden" name="_method" value="put">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <input type="text"  name="classes_name" id="classes_name{{$data->classes_id}}" class="form-control" placeholder="科室名称" value="{{$data->classes_name}}" required autofocus><br>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-warning" onclick='return edit({{$data->classes_id}},"classid{{$data->classes_id}}");'>修改</button>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">返回</button>
                                                            </form>
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
            </div>
        </div>
    </div>
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('layer/layer.js')}}"></script>
    <script language="javascript">
        $(function(){
            $.ajaxSetup ({
                cache: false //关闭AJAX缓存
            });
        });

        function Classes_Del(id){
            var info="DELETE FROM `new_whp`.`goods` WHERE `goods_classes`=?;;:"
            +"DELETE FROM `new_whp`.`admin_classes` WHERE `admin_classes_classes`=?;"
            +"DELETE FROM `new_whp`.`classes` WHERE `classes_id`=?;"+id+";:"+id+";:"+id;
            var data={"bag_id":"updateSql","info":info,"terminal_id":id};
            $.ajax({
                        type:"post",
                        async: false,
                        url:"http://120.76.245.91:888/hou/httpHandler.do",
                        dataType: "jsonp",
                        jsonp: "mugui",
                        jsonpCallback:"end",
                        data:data,
                        success: function(json){
                            var bag_id=json.bag_id;
                            if(bag_id=="updateSql"){
                                $.post('classes/'+id,{'_method':'delete','_token':'{{csrf_token()}}'},function(data){
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
                            layer.msg("终端传输失败，请重新操作", {icon: 5});
                        }
                    }
            );
            return true;
        }

        function ClassesDelete(id){
            layer.confirm('确定删除？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                Classes_Del(id);
            }, function(){
            });
        }

        function edit(id,id1){
            var new_name=$("#classes_name"+id).val();
			if(new_name==""){
				layer.msg("科室名称不能为空！", {icon: 5});
				return false;
			}else{
			var ids=$("#"+id1).val();
            var info="UPDATE `new_whp`.`classes` SET `classes_name`=? WHERE `classes_id`=?;:"+new_name+","+id;
            var data={"bag_id":"updateSql","info":info,"terminal_id":ids};
            $.ajax({
                        type:"post",
                        async: false,
                        url:"http://120.76.245.91:888/hou/httpHandler.do",
                        dataType: "jsonp",
                        jsonp: "mugui",
                        jsonpCallback:"end",
                        data:data,
                        success: function(json){
                            var bag_id=json.bag_id;
                            if(bag_id=="updateSql"){
                               $("#form_id"+id).submit();
                                return false;
                            }else if(bag_id=="error"){
                                layer.msg(json.info, {icon: 5});
                                return false;
                            }
                        },
                        error: function() {
                            layer.msg("终端传输失败，请重新操作", {icon: 5});
                        }
                    }
            );
            return false;
			}
        }
    </script>
@endsection