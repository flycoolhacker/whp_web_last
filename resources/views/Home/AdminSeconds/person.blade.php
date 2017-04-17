@extends('layout.main')
@section('tit_bla')
    @parent
    <li><a href="/admin">物资</a></li>
    <li class="active"><a href="/person">人员</a></li>
    <li><a href="/classes">科室管理</a></li>
    <li><a href="/dangernews">日志</a></li>
    <li><a href="/logout" style="color: red">退出</a></li>
@endsection
@section('content')
    <div style="height:100%;width:100%;z-index:-10;position:fixed;">
        <img style="height:100%;width:100%" src="img/bg1.jpg">
    </div>
    <div style="height:50px;"></div>
    <div class="con-body">
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
                {{--左侧导航--}}
                <div class="col-sm-2 ">


                    {{--<ul class="nav nav-sidebar nav-pills nav-stacked" style="background-color: #F5F5F5;">--}}
                        {{--<li class="active"><a><h4>管理类别选择</h4></a></li>--}}
                        {{--<li class="active"><a href="/person">单位人员管理</a></li>--}}
                        {{--<li><a href="/classes">科室管理</a></li>--}}
                    {{--</ul>--}}


                    <ul class="nav nav-sidebar nav-pills nav-stacked" style="background-color: #F5F5F5;">
                        <li class="active"><a><h4>人员类别选择</h4></a></li>
                        <li class="active"><a href="/person">单位人员管理</a></li>
                        <li><a href="/secondAdmins">科室管理员管理</a></li>
                        <br>
                        <li class="active"><a><h4>单位人员搜索</h4></a></li>
                        <br>
                        <form action="/person" method="get">
                            <input type="text"  name="person_name" class="form-control" placeholder="姓名" required autofocus>
                            <br>
                            <button id="SC_submit" class="btn btn-primary btn-block" type="submit">搜索</button>
                            <br>
                        </form>
                        <button class="btn btn-primary btn-block " data-toggle="modal" data-target="#addperson">添加单位人员</button>
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
                                <li><a href="javascript:;">物资</a></li>
                                <li><a href="javascript:;">单位人员管理</a></li>
                            </ol>
                            <h4>
                                    <div class="modal fade" id="addperson" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">添加单位人员</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="/person" method="post">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        编码：<input type="number"  name="person_ids" class="form-control" placeholder="编码" required autofocus><br>
                                                        姓名：<input type="text"  name="person_name" class="form-control" placeholder="姓名" required autofocus><br>
                                                        性别：<select class="form-control" name="person_sex" value="gtxittan" >
                                                            @foreach ($SexData as $value)
                                                                <option value="{{$value->sex_name}}">{{$value->sex_name}}</option>
                                                            @endforeach
                                                              </select><br>
                                                        工牌：<input type="text"  name="person_num" class="form-control" placeholder="工牌" required autofocus><br>
                                                        科室：<select class="form-control" name="person_classes" value="gtxittan" >
                                                            @foreach ($ClassesData as $value)
                                                                <option value="{{$value->classes_id}}">{{$value->classes_name}}</option>
                                                            @endforeach
                                                        </select><br>
                                                        人员类别：<select class="form-control" name="person_class" value="gtxittan" >
                                                            @foreach ($ClassData as $value)
                                                                <option value="{{$value->person_class_name}}">{{$value->person_class_name}}</option>
                                                            @endforeach
                                                        </select><br>
                                                        电话：<input type="number"  name="person_phone" class="form-control" placeholder="电话" required autofocus><br>
                                                        人员属性：<select class="form-control" name="person_job" value="gtxittan" >
                                                            @foreach ($JobData as $value)
                                                                <option value="{{$value->job_name}}">{{$value->job_name}}</option>
                                                            @endforeach
                                                        </select><br>
                                                        备注：<input type="text"  name="person_add" class="form-control" placeholder="备注" required autofocus><br>

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
                                    <th><span class="glyphicon glyphicon-list-alt"></span>编码</th>
                                    <th><span class="glyphicon glyphicon-user"></span>姓名</th>
                                    <th><span class="glyphicon glyphicon-paperclip"></span>性别</th>
                                    <th><span class="glyphicon glyphicon-edit"></span>工作牌</th>
                                    <th><span class="glyphicon glyphicon-home"></span>科室</th>
                                    <th><span class="glyphicon glyphicon-stats"></span>人员属性</th>
                                    <th><span class="glyphicon glyphicon-map-marker"></span>人员类别</th>
                                    <th><span class="glyphicon glyphicon-phone-alt"></span>联系电话</th>
                                    <th><span class="glyphicon glyphicon-th-large"></span>备注</th>
                                    <th  style="width:93px;"><span class="glyphicon glyphicon-map-marker"></span>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($PersonData as $data)
                                    <tr>
                                        <td>{{$data->person_ids}}</td>
                                        <td>{{$data->person_name}}</td>
                                        <td>{{$data->person_sex}}</td>
                                        <td>{{$data->person_num}}</td>
                                        <td>{{$data->classes_name}}</td>
                                        <td>{{$data->person_job}}</td>
                                        <td>{{$data->person_class}}</td>
                                        <td>{{$data->person_phone}}</td>
                                        <td>{{$data->person_add}}</td>
                                        <td><!-- Button trigger modal -->
                                            <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#moreperson{{$data->person_id}}">
                                                编辑
                                            </button>
                                            <button type="button" onclick="PersonDelete({{$data->person_id}})" class="btn btn-danger btn-xs">删除</button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="moreperson{{$data->person_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">当前人员：{{$data->person_name}}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{url('/person/'.$data->person_id)}}" method="post">
                                                                <input type="hidden" name="_method" value="put">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            编码：<input type="number"  name="person_ids" class="form-control" placeholder="编码" value="{{$data->person_ids}}" required autofocus><br>
                                                            姓名：<input type="text"  name="person_name" class="form-control" placeholder="姓名" value="{{$data->person_name}}" required autofocus><br>
                                                            性别：<select class="form-control" name="person_sex" value="{{$data->person_sex}}" >
                                                                @foreach ($SexData as $value)
                                                                    <option @if(strcmp($data->person_sex,$value->sex_name)==0)
                                                                            selected
                                                                            @endif value="{{$value->sex_name}}">{{$value->sex_name}}</option>
                                                                @endforeach
                                                            </select><br>
                                                            工牌：<input type="text"  name="person_num" class="form-control" placeholder="工牌" value="{{$data->person_num}}" required autofocus><br>
                                                            科室：<select class="form-control" name="person_classes" value="{{$data->person_classes}}" >
                                                                @foreach ($ClassesData as $value)
                                                                    <option @if(strcmp($data->person_classes,$value->classes_name)==0)
                                                                            selected
                                                                            @endif value="{{$value->classes_id}}">{{$value->classes_name}}</option>
                                                                @endforeach
                                                            </select><br>
                                                            人员类别：<select class="form-control" name="person_class" value="{{$data->person_class}}" >
                                                                @foreach ($ClassData as $value)
                                                                    <option @if(strcmp($data->person_class,$value->person_class_name)==0)
                                                                            selected
                                                                            @endif
                                                                            value="{{$value->person_class_name}}">{{$value->person_class_name}}</option>
                                                                @endforeach
                                                            </select><br>
                                                            电话：<input type="number"  name="person_phone" class="form-control" placeholder="电话" value="{{$data->person_phone}}" required autofocus><br>
                                                            人员属性：<select class="form-control" name="person_job" value="{{$data->person_job}}" >
                                                                @foreach ($JobData as $value)
                                                                    <option @if(strcmp($data->person_job,$value->job_name)==0)
                                                                            selected
                                                                            @endif value="{{$value->job_name}}">{{$value->job_name}}</option>
                                                                @endforeach
                                                            </select><br>
                                                            备注：<input type="text"  name="person_add" class="form-control" placeholder="备注" value="{{$data->person_add}}" required autofocus><br>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-warning">修改</button>
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
        function PersonDelete(id){
            layer.confirm('确定删除？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post('person/'+id,{'_method':'delete','_token':'{{csrf_token()}}'},function(data){
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
@endsection