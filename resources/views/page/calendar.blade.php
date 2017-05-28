
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="keywords" content="sms" />
    <meta name="author" content="maple.xia" />

    <title>日历事件</title>

    <!-- Bootstrap core CSS -->



<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    {!! HTML::script('js/html5shiv.min.js') !!}
    {!! HTML::script('js/respond.min.js') !!}
    <![endif]-->

    <!-- this page specific styles -->
    {!! HTML::style('css/calendar/calendar.css') !!}
    {!! HTML::style('css/calendar/fullcalendar.css') !!}
</head>
<body>
<div id="pad-wrapper">
    <div class="row calendar-wrapper">
        <div class="col-md-12">

            <!-- div that fullcalendar plugin uses  -->
            <div id='calendar'></div>
        </div>
    </div>
</div>

<!-- end main container -->

@include('partials.js_basic')
<!-- scripts for this page -->

{!! HTML::script('vendor/fullcalendar.min.js') !!}
<!-- builds fullcalendar example -->
<script>
    $(document).ready(function() {

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        $('#calendar').fullCalendar({
            header: {
                left: 'month,agendaWeek,agendaDay',
                center: 'title',
                right: 'today prev,next'
            },
            selectable: true,
            selectHelper: true,
            editable: true,
            /*events: [
                {
                    title: 'All Day Event',
                    start: new Date(y, m, 1)
                },
                {
                    title: 'Long Event',
                    start: new Date(y, m, d-5),
                    end: new Date(y, m, d-2)
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: new Date(y, m, d-3, 16, 0),
                    allDay: false
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: new Date(y, m, d+4, 16, 0),
                    allDay: false
                },
                {
                    title: 'Meeting',
                    start: new Date(y, m, d, 10, 30),
                    allDay: false
                },
                {
                    title: 'Lunch',
                    start: new Date(y, m, d, 12, 0),
                    end: new Date(y, m, d, 14, 0),
                    allDay: false
                },
                {
                    title: 'Birthday Party',
                    start: new Date(y, m, d+1, 19, 0),
                    end: new Date(y, m, d+1, 22, 30),
                    allDay: false
                },
                {
                    title: 'Click for Google',
                    start: new Date(y, m, 28),
                    end: new Date(y, m, 29),
                    url: 'http://google.com/'
                }
            ],*/
            eventBackgroundColor: '#278ccf'
        });
    });
</script>
</body>
</html>