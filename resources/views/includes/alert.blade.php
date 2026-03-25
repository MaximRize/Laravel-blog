@if($alert = session('alert'))
<div class="alert alert-success text-center" role="alert">
    {{ $alert }}
</div>
@endif

@if($alert = session('danger'))
    <div class="alert alert-danger text-center" role="alert">
        {{ $alert }}
    </div>
@endif

{{--@error('email')--}}
{{--<div class="alert alert-danger text-center m-0" role="alert">--}}
{{--    {{$message}}--}}
{{--</div>--}}
{{--@enderror--}}

{{--@error('password')--}}
{{--<div class="alert alert-danger text-center m-0" role="alert">--}}
{{--    {{$message}}--}}
{{--</div>--}}
{{--@enderror--}}

{{--@error('title')--}}
{{--<div class="alert alert-danger text-center m-0" role="alert">--}}
{{--    {{$message}}--}}
{{--</div>--}}
{{--@enderror--}}

{{--@error('content')--}}
{{--<div class="alert alert-danger text-center m-0" role="alert">--}}
{{--    {{$message}}--}}
{{--</div>--}}
{{--@enderror--}}
