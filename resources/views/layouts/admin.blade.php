
@extends('layouts.base')

@section('content')
    <section>
        <x-container>
            <nav class="navbar navbar-expand-lg navbar-light bg-light rounded mb-4">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('admin.posts') }}">Админ кабинет</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#userNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="userNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.posts') }}">
                                    {{__('Все посты ')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.users') }}">
                                    {{__('Пользователи ')}}
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                    {{ auth()->user()->name ?? 'Никто' }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <form method="GET" action="{{ route('logout') }}">
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

            @yield('admin.content')
        </x-container>
    </section>
@endsection
