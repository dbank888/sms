@extends('layouts.app')

@section('title', '保险公司列表')

@section('load_css')
    {!! HTML::style('vendor/jqPagination/css/jqpagination.css') !!}
@endsection

@section('customize_css')
    <style>
        .table td,th {
            text-align: center;
        }

        .btn-new, .btn-import{
            margin-right: 10px;
        }

        .btn-search{
            float: right!important;
        }
    </style>
@endsection


@section('content')
    <div class="container">
        <div class="header clearfix">
            <h3 class="text-muted text-center">保险公司信息列表</h3>

            <div class="row">
                <div class="col-md-4">
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
                                <form id="import-form">
                                    <div class="modal-body">
                                        <a class="btn btn-primary pull-right" href="/download/company.xlsx">
                                            <span class="glyphicon glyphicon-save" aria-hidden="true"></span> 下载导入模版
                                        </a>
                                        <div class="form-group">
                                    <textarea id="import-content" class="form-control" rows="10"
                                              placeholder="必填项，下载填写模板文件，选择需要导入条目复制粘贴到本输入框"  data-error="请填写导入条目" required></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button id="import" type="submit" class="btn btn-primary">导入</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-success btn-new" href="/company/create">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加
                    </a>
                </div>
                <div class="col-md-8">
                    {{--<a class="btn btn-success btn-search" ">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> 搜索
                    </a>--}}
                </div>
            </div>
        </div>
        <div>
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

        @include('partials.pageination')
    </div><!-- /.container -->
@endsection

@section('load_js')
    {!! HTML::script('vendor/jqPagination/js/jquery.jqpagination.js') !!}
@endsection


@section('customize_js')
    <script>
        $(document).ready(function() {
            //auto loading
            loadList(1);

            //event
            $("#list-rows").change(function(){
                loadList(1);
            })

            $('#import-form').validator().on('submit', function (e) {
                if (e.isDefaultPrevented()) {
                    //alert('form is not valid');
                } else {
                    e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: base_path + "/api/company/import",
                        data: {content:$('#import-content').val()},
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
                }
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
                            if(undefined != item[i].service){
                                html+="<td>"+item[i]['service']['name']+"</td>";
                            }else{
                                html+="<td></td>";
                            }
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
                        page_string: ' {current_page}／{max_page} 页 ',
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

