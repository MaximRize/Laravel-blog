@extends('layouts.user')

@section('title', __('Создать пост'))

@section('user.content')
    <x-title>
        {{ __('Создать пост') }}
        <x-slot name="link">
            <a href="{{ route('user.posts') }}">{{ __('Назад к списку') }}</a>
        </x-slot>
    </x-title>

    <x-post.form action="{{ route('user.posts.store') }}">
        {{ __('Создать') }}
    </x-post.form>
@endsection
