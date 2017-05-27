@extends('layouts.app')

@section('title', '保险公司列表')

@section('load_css')
    {!! HTML::style('css/sms/datatables.min.css') !!}
    {!! HTML::style('vendor/jqPagination/css/jqpagination.css') !!}
@endsection

@section('customize_css')
    <style>
        .table td,th {
            text-align: center;
        }

        .txt-center{
            text-align: center;
        }

        .btn-new, .btn-import{
            float: right!important;
            margin: -30px 10px 0 0;
        }
    </style>
@endsection


@section('content')
    <div class="container">
        <div class="header clearfix">
            <h3 class="text-muted txt-center">保险公司信息列表</h3>
            <button type="button" class="btn btn-primary btn-import" data-toggle="modal" data-target="#myModal">
                <span class="glyphicon glyphicon-import" aria-hidden="true"></span> 批量导入
            </button>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">数据批量导入</h4>
                        </div>
                        <div class="modal-body">
                            <a class="btn btn-primary pull-right" href="/download/company.xlsx">
                                <span class="glyphicon glyphicon-save" aria-hidden="true"></span> 下载导入模版
                            </a>
                            <textarea id="import-content" class="form-control" rows="12" placeholder="必填项，下载填写模板文件，选择需要导入条目复制粘贴到本输入框"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button id="import" type="button" class="btn btn-primary">导入</button>
                        </div>
                    </div>
                </div>
            </div>
            <a class="btn btn-success btn-new" href="/service/create">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加
            </a>
        </div>
        <div style="margin: 10px;">
            <table id="company-list" class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>保险公司</th>
                    <th>车架号</th>
                    <th>车牌号</th>
                    <th>服务商</th>
                    <th>联系方式</th>
                    <th>修改时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody id="list_content">

                </tbody>
            </table>
        </div>

        <div style="margin: 20px 0;display: inline-block;">
            <label>Show </label>
            <select id="list-rows" aria-controls="user-list" class="">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <label>entries</label>
        </div>
        <div class="pagination pull-right">
            <a href="#" class="first" data-action="first">&laquo;</a>
            <a href="#" class="previous" data-action="previous">&lsaquo;</a>
            <input type="text" readonly="readonly" data-max-page="40" />
            <a href="#" class="next" data-action="next">&rsaquo;</a>
            <a href="#" class="last" data-action="last">&raquo;</a>
        </div>

    </div><!-- /.container -->
@endsection

@section('load_js')
    {!! HTML::script('vendor/jqPagination/js/jquery.jqpagination.js') !!}
@endsection


@section('customize_js')
    <script>
        $(document).ready(function() {

            //event
            $("#nav-company").addClass('active');
            $("#list-rows").change(function(){
                loadList(1);
            })

            $("#import").click(function(){
                var _content = $('#import-content').val();
                if(_content.length == 0){
                    error('内容不能为空');
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url: base_path + "/api/company/import",
                    data: {content:_content},
                    dataType: "json",
                    error: function (request) {
                        info(request.responseJSON.ErrorMsg);
                    },
                    success: function(rs){
                        loadList(1);
                        $('#myModal').modal('hide');
                        success(rs.msg);
                    }
                });
            });

            $(document).on("click", ".del", function(){
                if(window.confirm('是否确认删除？')){
                    $.ajax({
                        type: "POST",
                        url: base_path + "/api/company/delete",
                        data: {id:$(this).attr('tag')},
                        dataType: "json",
                        success: function(rs){
                            var current_page = $('.pagination').jqPagination('option','current_page');
                            loadList(current_page);
                        }
                    })
                }
            })

            //auto loading
            loadList(1);
        });

        function loadList(page){
            var _listRows = $("#list-rows").val();

            $.ajax({
                type: "POST",
                url: base_path + "/api/company/dataList",
                data: {page:page,listRows:_listRows},
                dataType: "json",
                error: function (request) {
                    error(request.responseJSON.ErrorMsg);
                },
                success: function(rs){
                    var item = rs.data.list;
                    var $content = $('#list_content');
                    $content.empty();
                    var html = '';
                    if(false == item){
                        var colspan = $("#company-list th").length;
                        html += '<tr><td colspan="'+ colspan +'" style="text-align: center;color: #999;">No records found</td></tr>';
                    }else{
                        for(var i=0;i<item.length;i++){
                            html+='<tr>';
                            html+="<td>"+item[i]['name']+"</td>";
                            html+="<td>"+item[i]['car_id']+"</td>";
                            html+="<td>"+item[i]['license']+"</td>";
                            html+="<td>"+item[i]['service']['name']+"</td>";
                            html+="<td>"+item[i]['mobile']+"</td>";
                            html+="<td>"+item[i]['updated_at']+"</td>";
                            html+= '<td><a class="btn btn-info" href="company/' + item[i]['id'] + '/edit" >编辑</a>' +
                                '<a class="btn btn-danger del" style="margin-left: 20px;" tag="'+ item[i]['id'] +'">删除</a></td>'
                            html+="</tr>";
                        }
                    }
                    $content.append(html);

                    //pagination
                    $('.pagination').jqPagination({
                        max_page:rs.data.max_page,
                        paged: function(page) {
                            // do something with the page variable
                            loadList(page);
                        }
                    });
                }
            });
        }
    </script>
@endsection

