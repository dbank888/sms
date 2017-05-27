@extends('layouts.app')

@section('title', '编辑公司记录')


@section('load_css')

@endsection

@section('customize_css')
    <style>

    </style>
@endsection


@section('content')
    <div class="container">

        <div style="margin: 10px;">
            <form id="service-form">
                <div class="form-group">
                    <label for="name">服务商名称</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="名称" />
                </div>
                <div class="form-group">
                    <label for="car_id">联系方式</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="联系方式" />
                </div>
                <div class="form-group">
                    <label for="license">优先级</label>
                    <select multiple class="form-control" id="priority" name="priority">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="server_id">省份</label>
                    <input type="text" class="form-control" id="province" name="province" placeholder="省份" />
                </div>
                <div class="form-group">
                    <label for="server_id">城市</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="城市" />
                </div>
                <div class="form-group">
                    <label for="server_id">区</label>
                    <input type="text" class="form-control" id="district" name="district" placeholder="区" />
                </div>
                <div class="form-group">
                    <label for="server_id">街道</label>
                    <input type="text" class="form-control" id="street" name="street" placeholder="街道" />
                </div>
                <div class="form-group">
                    <label for="server_id">道路</label>
                    <input type="text" class="form-control" id="road" name="road" placeholder="道路" />
                </div>

                <input id="id" name="id" type="hidden" />
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
            //global params
            var service_id = '{!! $service_id !!}';

            $.ajax({
                type: "post",
                url: base_path + '/api/service/editInfo',
                data: {id:service_id},
                error: function (request) {
                    error(request.responseJSON.ErrorMsg);
                },
                success: function (rs){
                    $.each(rs.data.info,function(index,value){
                        var element = "#" + index;
                        $(element).val(value);
                    })
                }
            });

            //event
            $('#submit').click(function(){
                update();
            });

        });

        /**
         * 更新数据
         */
        function update(){
            var _values = $("#service-form").serializeArray();
            $.ajax({
                type: "post",
                url: base_path + "/api/service/update",
                data: _values,
                error: function (request) {
                    info(request.responseJSON.ErrorMsg);
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

