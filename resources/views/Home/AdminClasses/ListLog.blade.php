<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="ie-stand">
    <title></title>
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap-theme.min.css')}}">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{asset('js/jquery.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
</head>
<body>
<div style="height:100%;width:100%;z-index:-10;position:fixed;">
    <img style="height:100%;width:100%" src="{{url('img/bg1.jpg')}}">
</div>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/classesdangernews" class="navbar-brand">危险化学品出入库记录</a>
        </div>
        <div class="collapse navbar-collapse navbar-responsive-collapse pull-right">
            <ul class="nav navbar-nav">

            </ul>
        </div>
    </div>
</nav>

</body>
<div class="container-fluid" style="margin-top:50px;">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-default" style="margin-top:20px;">
                <div class="panel-body">
                    @if(count($errors)>0)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-warning alert-dismissible text-center" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <strong>{{$error}}!</strong>
                            </div>
                        @endforeach
                    @endif
                    <table class="table table-bordered table-responsive table-striped table-hover">
                        <thead>
                        <tr>
                            <th colspan="19">
                                <form action="{{url('/logExcleShow')}}" method="post" class="form-inline" role="form">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <label class="sr-only" for="starttime">开始时间</label>
                                        <input type="hidden" name="starttime" value="{{$TimeData['starttime']}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="stoptime">终止时间</label>
                                        <input type="hidden" name="stoptime" value="{{$TimeData['stoptime']}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="">药品类型</label>
                                        <input type="hidden" name="YP_type" value="1">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="">排序</label>
                                        <input type="hidden" name="desc" value="{{$TimeData['desc']}}">
                                    </div>
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-info">导出Excle</button>
                                    </div>
                                </form>
                                <h4>科室：{{session('now_classes')}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;时间段：{{$TimeData['starttime']}} ——  {{$TimeData['stoptime']}}</h4>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>时间</th>
                            <th>危险化学品名称</th>
                            <th>数量单位</th>
                            <th>库存总量</th>
                            <th>入库量</th>
                            <th>出库(消耗)量</th>
                            <th>现有量</th>
                            <th>记账管理(负责人)</th>
                            <th>记物管理(责任人)</th>
                            <th>领用人</th>
                            <th>使用监督人</th>
                        </tr>
                        @foreach($logs_data as $logs)
                            <tr>
                                <td>{{$logs->log_time}}</td>
                                <td>{{$logs->log_goods_name}}</td>
                                <td>{{$logs->log_goods_units}}</td>
                                <td>{{$logs->log_goods_all}}</td>
                                <td>{{$logs->log_goods_in}}</td>
                                <td>{{$logs->log_goods_out}}</td>
                                <td>{{$logs->log_goods_now}}</td>
                                <td>{{$logs->log_mcmater_master}}</td>
                                <td>{{$logs->log_account_master}}</td>
                                <td>{{$logs->log_user}}</td>
                                <td>{{$logs->log_use_master}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <ul id="fenye" class="list">
                        {!! $logs_data->appends(['starttime'=>$TimeData["starttime"]])->appends(['stoptime'=>$TimeData["stoptime"]])->appends(['desc'=>$TimeData['desc']])->appends(['YP_type'=>$TimeData["YP_type"]])->links() !!}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</html>