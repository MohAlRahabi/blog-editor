<script>
    var BASE_URL = '{{url('')}}' + '/';
    var _token = '{{csrf_token()}}';
</script>

<!-- App js -->
<script src="{{asset("js/app.js")}}"></script>
<script src="{{asset("js/custom.js")}}"></script>
@stack('scripts')
