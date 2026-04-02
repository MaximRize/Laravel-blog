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

