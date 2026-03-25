@php($id = Str::uuid())

<div class="form-check">
    <input {{ $attributes->class([
    'form-check-input',
]) ->merge([
    'value'=>'1',
]) }} type="checkbox" id="{{ $id }}">

    <label {{$attributes->class([
    'form-check-label',
]) }} for="{{ $id }}">
        {{$slot}}
    </label>
</div>
