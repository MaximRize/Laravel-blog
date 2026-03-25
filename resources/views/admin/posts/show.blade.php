@extends('layouts.admin')

@section('title', $post->title)

@section('admin.content')
    <x-title>
        {{ $post->title }}
        <x-slot name="right">
            <x-button-link href="{{ route('user.posts.edit', $post) }}" class="btn-sm btn-outline-secondary">
                <i class="bi bi-pencil"></i> {{ __('Изменить') }}
            </x-button-link>
            <form action="{{ route('user.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Удалить пост?') }}')">
                @csrf
                @method('DELETE')
                <x-button type="submit" class="btn-sm btn-outline-danger">
                    <i class="bi bi-trash"></i> {{ __('Удалить') }}
                </x-button>
            </form>
        </x-slot>
        <x-slot name="link">
            <a href="{{ route('admin.posts') }}">{{ __('Назад к списку') }}</a>
        </x-slot>
    </x-title>

    <div class="mb-3">
        @if($post->published)
            <span class="badge bg-success">{{ __('Опубликовано') }}</span>
        @else
            <span class="badge bg-warning text-dark">{{ __('Черновик') }}</span>
        @endif
    </div>

    <div class="small text-muted mb-3">
        {{ $post->created_at->format('d.m.Y H:i') }}
    </div>

    @if($post->image)
        <div style="position: relative; width: 100%; padding-top: 56.25%; overflow: hidden; border-radius: 0.5rem;">
            <img src="{{ asset('storage/' . $post->image) }}"
                 alt="{{ $post->title }}"
                 style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
        </div>
    @endif

    <div class="pt-3">
        {!! $post->content !!}
    </div>
@endsection
