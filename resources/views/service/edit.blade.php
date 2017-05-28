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
                    <input type="text" class="form-control" id="name" name="name" placeholder="名称 (必填项)"
                           data-error="请填写服务商名称" required/>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label for="car_id">联系方式</label>
                    <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="手机号码 (必填项)"
                           pattern="^1[3458]{1}\d{9}$" data-error="请填写正确手机号" required/>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label for="license">优先级</label>
                    <select multiple class="form-control" id="priority" name="priority"  data-error="请选择优先级" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <div class="help-block with-errors"></div>
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

                <div class="form-group">
                    <input id="id" name="id" type="hidden" />
                    <button id="submit" type="submit" class="btn btn-primary">提交</button>
                </div>
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
                    });

                    //event
                    $('#service-form').validator().on('submit', function (e) {
                        if (e.isDefaultPrevented()) {
                            //alert('form is not valid');
                        } else {
                            e.preventDefault();
                            update();
                        }
                    });
                }
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

