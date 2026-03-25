<header class="pb-3 border-bottom">

    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{route('home')}}">
                {{config('app.name')}}
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link {{activeLink('home')}}" aria-current="page" href="{{route('home')}}">
                            {{__('Главная')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{activeLink('blog*')}}" aria-current="page" href="{{route('blog')}}">
                            {{__('Блог')}}
                        </a>
                    </li>
                </ul>

                @if(auth()->guest())
                <ul class="navbar-nav ms-auto ms-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link {{activeLink('register')}}" aria-current="page" href="{{route('register')}}">
                            {{__('Регистрация')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{activeLink('login')}}" aria-current="page" href="{{route('login')}}">
                            {{__('Вход')}}
                        </a>
                    </li>
                </ul>
                @endif

                @if(auth()->check())
                    <ul class="navbar-nav ms-auto ms-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{route('logout')}}">
                                {{__('Выход')}}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{route('user.posts')}}">
                                {{__('Мои посты')}}
                            </a>
                        </li>
                    </ul>
                @endif

            </div>
        </div>
    </nav>
</header>

