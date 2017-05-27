@extends('layouts.app')

@section('title', '新建保险公司')


@section('load_css')

@endsection

@section('customize_css')
    <style>

    </style>
@endsection


@section('content')
    <div class="container">

        <div style="margin: 10px;">
            <form id="company-form">
                <div class="form-group">
                    <label for="name">保险公司名称</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="名称" />
                </div>
                <div class="form-group">
                    <label for="car_id">车架号</label>
                    <input type="text" class="form-control" id="car_id" name="car_id" placeholder="车架号" />
                </div>
                <div class="form-group">
                    <label for="license">车牌号</label>
                    <input type="text" class="form-control" id="license" name="license" placeholder="车牌号" />
                </div>
                <div class="form-group">
                    <label for="server_id">服务商</label>
                    <select multiple class="form-control" id="server_id" name="service_id">

                    </select>
                </div>
                <input id="submit" type="button" class="btn btn-default" value="提交" />
            </form>
        </div>
    </div><!-- /.container -->
@endsection

@section('load_js')

@endsection


@section('customize_js')
    <script>
        $(document).ready(function() {
            loadConfig();
            $('#submit').click(function(){
                create();
            });

        });

        function loadConfig(){
            $.ajax({
                type: "POST",
                url: base_path + "/api/company/createConf",
                dataType: "json",
                success: function (rs) {
                    var item = rs.data;
                    var html = '';
                    $.each(item.service,function(key,val){
                        html = '<option value="'+ val['key'] +'">'+ val['value'] +'</option>'
                        $("#server_id").append(html);
                    })
                }
            });
        }

        function create(){
            var _values = $("#company-form").serializeArray();
            $.ajax({
                type: "post",
                url: base_path + "/api/company/store",
                data: _values,
                error: function (request) {
                    error(request.responseJSON.ErrorMsg);
                },
                success: function (rtn){
                    success(rtn.msg);
                    window.setTimeout(function(){
                        if ( rtn.url != undefined ) {
                            window.location.href = rtn.url;
                        }
                    }, 2000);
                }
            });
        }

    </script>
@endsection

