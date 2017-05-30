@extends('layouts.model')

@section('title', '短信记录')

@section('load_css')
    {!! HTML::style('vendor/jqPagination/css/jqpagination.css') !!}
@endsection

@section('customize_css')
    <style>
        table td,th {
            overflow: hidden; /* this is what fixes the expansion */
            text-overflow: ellipsis; /* not supported in all browsers, but I accepted the tradeoff */
            white-space: nowrap;
            max-width: 200px!important;
            text-align: center;
        }

        .search-input{
            height: 34px;
            padding: 6px 12px;
            margin-right: 10px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
@endsection


@section('content')
    <div class="container">
        <div class="header clearfix">
            <h3 class="text-muted text-center">短信分发记录</h3>

            <div class="row">
                <div class="col-md-4">
                    <a class="btn btn-success " href="/api/sms/export">
                        <span class="glyphicon glyphicon-open" aria-hidden="true"></span> Excel导出
                    </a>
                </div>
                <div class="col-md-8">
                    <form id="form-search">
                        <a id="btn-search" class="btn btn-primary pull-right">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span> 搜索
                        </a>
                        <div class="form-group pull-right">
                            <label for="send_status">转发状态</label>
                            <select id="send_status" name="send_status" class="search-input">
                                <option value="0">--不限--</option>
                                <option value="-1">未转发</option>
                                <option value="1">已转发</option>
                            </select>
                        </div>
                        <div class="form-group pull-right">
                            <label for="content">短信内容</label>
                            <input id="content" name="content" class="search-input" placeholder="短信内容">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div>
            <table id="sms-list" class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>来电号码</th>
                    <th>内容</th>
                    <th>转发状态</th>
                    <th>接收时间</th>
                    <th>转发号码</th>
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
            //event
            $("#list-rows").change(function(){
                loadList(1);
            });

            $("#btn-search").click(function(){
                loadList(1);
            });

            //auto loading
            loadList(1);
        });

        function loadList(page){
            var _data = $("#form-search").serializeArray().reduce(function(result, item){
                result[item.name] = item.value;
                return result;
            }, {});
            _data.page = page;
            _data.listRows = $("#list-rows").val();

            $.ajax({
                type: "POST",
                url: base_path + "/api/sms/dataList",
                data: _data,
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
                        var colspan = $("#sms-list th").length;
                        html += '<tr><td colspan="'+ colspan +'" style="text-align: center;color: #999;">No records found</td></tr>';
                    }else{
                        for(var i=0;i<item.length;i++){
                            html+='<tr>';
                            html+="<td>"+item[i]['mobile']+"</td>";
                            html+="<td data-container=\"body\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\""+ item[i]['content'] +"\">"+item[i]['content']+"</td>";
                            html+="<td>"+item[i]['send_status']+"</td>";
                            html+="<td>"+item[i]['created_at']+"</td>";
                            html+="<td>"+item[i]['send_mobile']+"</td>";
                            html+="</tr>";
                        }
                    }
                    $content.append(html);
                    $("[data-toggle='tooltip']").tooltip();

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
