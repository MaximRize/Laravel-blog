@if($errors->any())
    <div class="alert alert-danger rounded-0" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $message)
                <li>
                    {{$message}}
                </li>
            @endforeach
        </ul>
    </div>
@endif
