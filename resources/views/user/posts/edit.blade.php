@extends('layouts.user')

@section('title', __('Редактировать пост'))

@section('user.content')
    <x-title>
        {{ __('Редактировать пост') }} #{{ $post->id }}
        <x-slot name="link">
            <a href="{{ route('user.posts.show', $post) }}">{{ __('Назад к посту') }}</a>
        </x-slot>
    </x-title>

    <x-post.form
        :post="$post"
        action="{{ route('user.posts.update', $post) }}"
        method="PUT"
    >
        {{ __('Сохранить изменения') }}
    </x-post.form>
@endsection
