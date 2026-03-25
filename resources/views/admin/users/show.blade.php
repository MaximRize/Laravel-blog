@extends('layouts.admin')

@section('title', 'Просмотр пользователя')

@section('admin.content')
    <x-title>
        {{ __('Пользователь') }}: {{ $user->name }}
        <x-slot name="link">
            <a href="{{ route('admin.users') }}">{{ __('Назад к списку') }}</a>
        </x-slot>
    </x-title>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Основная информация</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>ID:</th>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th>Имя:</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Дата регистрации:</th>
                            <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Администратор:</th>
                            <td>
                                @if($user->is_admin)
                                    <span class="badge bg-success">Да</span>
                                @else
                                    <span class="badge bg-secondary">Нет</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Статус:</th>
                            <td>
                                @if($user->active)
                                    <span class="badge bg-success">Активен</span>
                                @else
                                    <span class="badge bg-danger">Забанен</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-4">Посты пользователя ({{ $user->posts->count() }})</h3>
    @if($user->posts->isEmpty())
        <p class="text-muted">У пользователя нет постов.</p>
    @else
        <div class="row g-4">
            @foreach($user->posts as $post)
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('user.posts.show', $post) ?? route('blog.show', $post) }}"
                                   target="_blank">
                                    {{ $post->title }}
                                </a>
                            </h5>
                            <p class="card-text text-muted small">
                                {{ Str::limit(strip_tags($post->content), 100) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small>Создан: {{ $post->created_at->format('d.m.Y') }}</small>
                                @if($post->published)
                                    <span class="badge bg-success">Опубликован</span>
                                @else
                                    <span class="badge bg-warning">Черновик</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <h3 class="mt-5">Комментарии пользователя ({{ $user->comments->count() }})</h3>
    @if($user->comments->isEmpty())
        <p class="text-muted">У пользователя нет комментариев.</p>
    @else
        @foreach($user->comments as $comment)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">Комментарий к посту:
                            <a href="{{ route('blog.show', $comment->post) }}"
                               target="_blank">{{ $comment->post->title }}</a>
                        </small>
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="mt-2">{{ $comment->body }}</p>
                </div>
            </div>
        @endforeach
    @endif
@endsection
