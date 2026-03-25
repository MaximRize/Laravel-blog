<form {{$attributes}}>
    @unless($attributes->get('method')== 'GET')
        @csrf
    @endunless
    {{$slot}}
</form>
