@extends('layouts.base')

@section('content')
    <section>
        <x-container>
            <nav class="navbar navbar-expand-lg navbar-light bg-light rounded mb-4">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('user.posts') }}">Мой кабинет</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#userNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="userNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.posts') }}">
                                    Мои посты
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.posts.create') }}">
                                    Создать пост
                                </a>
                            </li>
                            @if(auth()->user()->is_admin === true)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.posts') }}">
                                       Админ панель
                                    </a>
                                </li>
                            @endif
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                    {{ auth()->user()->name ?? 'Пользователь' }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Выйти</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            @yield('user.content')
        </x-container>
    </section>
@endsection
