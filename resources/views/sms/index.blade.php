{!! HTML::style('css/datatables.min.css') !!}
{!! HTML::style('css/buttons.dataTables.min.css') !!}

<style>
    .datatable td {
        overflow: hidden; /* this is what fixes the expansion */
        text-overflow: ellipsis; /* not supported in all browsers, but I accepted the tradeoff */
        white-space: nowrap;
        max-width: 200px;
        text-align: center;
    }

</style>

{!! HTML::script('js/jquery-1.12.4.js') !!}
{!! HTML::script('js/datatables.min.js') !!}
{!! HTML::script('js/dataTables.buttons.min.js') !!}
{!! HTML::script('js/buttons.flash.min.js') !!}
{!! HTML::script('js/jszip.min.js') !!}


<table id="sms-list" class="display" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>来电号码</th>
        <th>内容</th>
        <th>转发状态</th>
        <th>接收时间</th>
        <th>转发号码</th>
    </tr>
    </thead>

</table>

<script>

    var BASE_PATH = '{{ $base_path }}';



    $(document).ready(function() {
        $('#sms-list').DataTable({
            "ajax": BASE_PATH + '/api/sms/dataList',
            "sPaginationType": "full_numbers",
            dom: 'Bfrtip',
            buttons: [
                'excel'
            ],

            "columns": [
                { "data": "mobile" },
                { "data": "content" },
                { "data": "send_status" },
                { "data": "created_at" },
                { "data": "send_mobile"},
            ],
        });

        setTimeout(function(){
            $('.datatable tbody td').each(function(){
                var titleVal = $(this).text();
                if (typeof titleVal === "string" && titleVal !== '') {
                    $(this).attr('title', titleVal);
                }
            });
        },500);


    } );


</script>