@props(['post' => null])
<x-form method="POST" {{ $attributes->except('method') }} >
    @if($attributes->get('method')=== 'PUT')
        @method('PUT')
    @endif
    <x-form-item>
        <x-label required>{{__('Название поста')}}</x-label>
        <x-input name="title" value="{{ $post->title ?? '' }}" autofocus></x-input>
        <x-error name="title"/>
    </x-form-item>

    <x-form-item>
        <x-label required>{{__('Содержание поста')}}</x-label>
        <x-trix name="content" value="{{ $post->content ?? '' }}"/>
        <x-error name="content"/>
    </x-form-item>

    <x-button type="submit">
        {{$slot}}
    </x-button>

</x-form>
