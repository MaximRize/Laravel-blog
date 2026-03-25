@extends('layouts.admin')

@section('title', 'Админ панель')

@section('admin.content')
    <x-title>
        {{ __('Все посты') }}
    </x-title>

    @if ($posts->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-file-text" style="font-size: 3rem; color: #ccc;"></i>
            <p class="text-muted mt-3">{{ __('Нет ни одного поста.') }}</p>
        </div>
    @else
        <div class="row g-4">
            @foreach($posts as $post)
                <div class="col-12 col-md-6">
                    <div class="card h-100 shadow-sm hover-shadow position-relative">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 180px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('admin.posts.show', $post) }}" class="text-decoration-none text-dark stretched-link">
                                    {{ $post->title }}
                                </a>
                            </h5>
                            <p class="card-text text-muted small mb-2">
                                {{ Str::limit(strip_tags($post->content), 100) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="d-flex align-items-center text-muted small">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $post->created_at->format('d.m.Y') }}
                                </div>
                                @if($post->published)
                                    <span class="badge bg-success">{{ __('Опубликовано') }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ __('Черновик') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer bg-transparent d-flex justify-content-end gap-2" style="position: relative; z-index: 2;">
                            <x-button-link href="{{ route('user.posts.edit', $post) }}" class="btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i> {{ __('Изменить') }}
                            </x-button-link>
                            <form action="{{ route('user.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('{{ __('Удалить пост?') }}')">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" class="btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> {{ __('Удалить') }}
                                </x-button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    @endif
@endsection

@push('css')
    <style>
        .hover-shadow {
            transition: all 0.2s ease;
        }
        .hover-shadow:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        .card-footer {
            border-top: 1px solid rgba(0,0,0,0.05);
        }
        .card-img-top {
            border-top-left-radius: calc(0.375rem - 1px);
            border-top-right-radius: calc(0.375rem - 1px);
        }
    </style>
@endpush
