@props([
    'options'=>[],

])

<select {{ $attributes->class([
    'form-control',
    ]) }}>
    @foreach($options as $key => $option)
        <option value="{{ $key }}" {{ ($key == $attributes->get('value') ? 'selected' :'') }}>
            {{$option}}
        </option>
    @endforeach
</select>

