<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
{!! HTML::script('js/jquery-1.12.4.js') !!}
{!! HTML::script('js/bootstrap.min.js') !!}
{!! HTML::script('js/common.js') !!}
{!! HTML::script('js/theme.js') !!}
{!! HTML::script('vendor/layer/layer.js') !!}
{!! HTML::script('vendor/validator.js') !!}
<script>
    //global
    var csrf_token = '{!! csrf_token() !!}'
    var base_path = '{!! \Request::root() !!}'
</script>