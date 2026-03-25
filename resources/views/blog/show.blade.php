@extends('layouts.main')

@section('title', $post->title)

@section('main.content')
    <div class="container py-5">
        <!-- Навигация -->
        <div class="mb-4">
            <a href="{{ route('blog') }}" class="text-decoration-none text-muted hover-text-primary">
                <i class="bi bi-arrow-left me-1"></i>
                {{ __('Вернуться к блогу') }}
            </a>
        </div>

        <!-- Статья -->
        <article class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <!-- Заголовок статьи -->
                <header class="mb-5 text-center">
                    <h1 class="display-4 fw-bold mb-4">{{ $post->title }}</h1>

                    <!-- Мета-информация -->
                    <div class="d-flex justify-content-center align-items-center gap-4 text-muted">
                        <!-- Автор -->
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-light p-2 me-2">
                                <i class="bi bi-person"></i>
                            </div>
                            <span>{{ $post->user->name ?? 'Неизвестный автор' }}</span>
                        </div>

                        <!-- Разделитель -->
                        <span>•</span>

                        <!-- Дата -->
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-light p-2 me-2">
                                <i class="bi bi-calendar3"></i>
                            </div>
                            <time datetime="{{ $post->created_at->format('Y-m-d') }}">
                                {{ $post->created_at->format('d.m.Y') }}
                            </time>
                        </div>
                    </div>

                    <!-- Тэги -->
                    @if($post->tags && $post->tags->count() > 0)
                        <div class="mt-4">
                            @foreach($post->tags as $tag)
                                <span class="badge bg-light text-dark me-2 px-3 py-2 rounded-pill">
                                    <i class="bi bi-tag me-1"></i>
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </header>

                <!-- Изображение статьи (если есть) -->
                @if($post->image)
                    <div class="mb-5 text-center">
                        <img src="{{ asset('storage/' . $post->image) }}"
                             alt="{{ $post->title }}"
                             class="img-fluid rounded-4 shadow-lg">
                    </div>
                @endif

                <!-- Контент статьи -->
                <div class="article-content fs-5 lh-lg">
                    {!! $post->content !!}
                </div>

                <!-- Подвал статьи -->
                <footer class="mt-5 pt-4 border-top text-muted small">
                    <i class="bi bi-pencil-square me-1"></i>
                    Последнее обновление: {{ $post->updated_at->format('d.m.Y') }}
                </footer>

                <!-- ==================== БЛОК КОММЕНТАРИЕВ ==================== -->
                <div class="mt-5 pt-4">
                    <h3 class="h4 mb-4">Комментарии ({{ $post->comments->count() }})</h3>

                    {{-- Форма нового комментария (только для авторизованных) --}}
                    @auth
                        <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <label for="newComment" class="form-label">Ваш комментарий</label>
                                <textarea name="body" id="newComment" rows="3"
                                          class="form-control @error('body') is-invalid @enderror" required></textarea>
                                @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Отправить</button>
                        </form>
                    @else
                        <p class="text-muted"><a href="{{ route('login') }}">Войдите</a>, чтобы оставить комментарий.
                        </p>
                    @endauth

                    {{-- Список комментариев --}}
                    @php
                        // Группируем комментарии: родительские (parent_id = null) и ответы
                        $comments = $post->comments;
                        $parents = $comments->whereNull('parent_id');
                        $replies = $comments->whereNotNull('parent_id')->groupBy('parent_id');
                    @endphp

                    @forelse($parents as $comment)
                        {{-- Родительский комментарий --}}
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <strong>{{ $comment->user->name ?? 'Пользователь удалён' }}</strong>
                                        <span
                                            class="text-muted small ms-2">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div>
                                        @auth
                                            {{-- Кнопка редактирования (только автор) --}}
                                            @if(auth()->id() === $comment->user_id)
                                                <button class="btn btn-sm btn-outline-secondary"
                                                        onclick="editComment({{ $comment->id }})">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                            @endif

                                            {{-- Кнопка удаления (автор или админ) --}}
                                            @if(auth()->id() === $comment->user_id || (auth()->user()?->is_admin ?? false))
                                                <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Удалить комментарий?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Кнопка ответить (для всех авторизованных) --}}
                                            <button class="btn btn-sm btn-outline-primary"
                                                    onclick="replyTo({{ $comment->id }})">
                                                <i class="bi bi-reply"></i> Ответить
                                            </button>
                                        @endauth
                                    </div>
                                </div>

                                <p class="card-text">{{ $comment->body }}</p>

                                {{-- Форма редактирования (скрыта) --}}
                                @auth
                                    @if(auth()->id() === $comment->user_id)
                                        <form action="{{ route('comments.update', $comment) }}" method="POST"
                                              class="mt-2 d-none" id="edit-form-{{ $comment->id }}">
                                            @csrf
                                            @method('PUT')
                                            <textarea name="body" class="form-control form-control-sm"
                                                      rows="2">{{ $comment->body }}</textarea>
                                            <button type="submit" class="btn btn-sm btn-primary mt-1">Сохранить</button>
                                            <button type="button" class="btn btn-sm btn-secondary mt-1"
                                                    onclick="cancelEdit({{ $comment->id }})">Отмена
                                            </button>
                                        </form>
                                    @endif
                                @endauth

                                {{-- Форма ответа (скрыта) --}}
                                @auth
                                    <form action="{{ route('comments.store', $post) }}" method="POST"
                                          class="mt-2 d-none" id="reply-form-{{ $comment->id }}">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <textarea name="body" class="form-control form-control-sm" rows="2"
                                                  placeholder="Написать ответ..."></textarea>
                                        <button type="submit" class="btn btn-sm btn-primary mt-1">Ответить</button>
                                        <button type="button" class="btn btn-sm btn-secondary mt-1"
                                                onclick="cancelReply({{ $comment->id }})">Отмена
                                        </button>
                                    </form>
                                @endauth

                                {{-- Ответы на этот комментарий --}}
                                @if(isset($replies[$comment->id]))
                                    @foreach($replies[$comment->id] as $reply)
                                        <div class="ms-4 mt-3 border-start ps-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <strong>{{ $reply->user->name ?? 'Пользователь удалён' }}</strong>
                                                    <span
                                                        class="text-muted small ms-2">{{ $reply->created_at->diffForHumans() }}</span>
                                                </div>
                                                <div>
                                                    @auth
                                                        {{-- Кнопка редактирования ответа (только автор) --}}
                                                        @if(auth()->id() === $reply->user_id)
                                                            <button class="btn btn-sm btn-outline-secondary"
                                                                    onclick="editComment({{ $reply->id }})">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                        @endif

                                                        {{-- Кнопка удаления ответа (автор или админ) --}}
                                                        @if(auth()->id() === $reply->user_id || (auth()->user()?->is_admin ?? false))
                                                            <form action="{{ route('comments.destroy', $reply) }}"
                                                                  method="POST" class="d-inline"
                                                                  onsubmit="return confirm('Удалить комментарий?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                        class="btn btn-sm btn-outline-danger">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endauth
                                                </div>
                                            </div>
                                            <p class="mb-0">{{ $reply->body }}</p>

                                            {{-- Форма редактирования ответа (скрыта) --}}
                                            @auth
                                                @if(auth()->id() === $reply->user_id)
                                                    <form action="{{ route('comments.update', $reply) }}" method="POST"
                                                          class="mt-2 d-none" id="edit-form-{{ $reply->id }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <textarea name="body" class="form-control form-control-sm"
                                                                  rows="2">{{ $reply->body }}</textarea>
                                                        <button type="submit" class="btn btn-sm btn-primary mt-1">
                                                            Сохранить
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-secondary mt-1"
                                                                onclick="cancelEdit({{ $reply->id }})">Отмена
                                                        </button>
                                                    </form>
                                                @endif
                                            @endauth
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Пока нет комментариев. Будьте первым!</p>
                    @endforelse
                </div>
            </div>
        </article>
    </div>
@endsection

@push('css')
    <style>
        /* Стили для типографики статьи (те же, что были) */
        .article-content {
            font-family: 'Georgia', 'Times New Roman', serif;
            color: #2c3e50;
        }

        .article-content h2 {
            font-size: 2rem;
            font-weight: 600;
            margin-top: 3rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .article-content h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-top: 2.5rem;
            margin-bottom: 1rem;
        }

        .article-content p {
            margin-bottom: 1.8rem;
            line-height: 1.9;
        }

        .article-content a {
            color: #0d6efd;
            text-decoration: none;
            border-bottom: 1px dotted #0d6efd;
        }

        .article-content a:hover {
            border-bottom: 1px solid #0d6efd;
        }

        .article-content blockquote {
            margin: 2rem 0;
            padding: 1.5rem 2rem;
            background: linear-gradient(to right, #f8f9fa, #ffffff);
            border-left: 5px solid #0d6efd;
            border-radius: 0 10px 10px 0;
            font-style: italic;
            color: #495057;
        }

        .article-content blockquote p:last-child {
            margin-bottom: 0;
        }

        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            margin: 2rem 0;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .article-content ul,
        .article-content ol {
            margin: 1.5rem 0;
            padding-left: 2rem;
        }

        .article-content li {
            margin-bottom: 0.5rem;
            line-height: 1.8;
        }

        .article-content pre {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 10px;
            overflow-x: auto;
            border: 1px solid #e9ecef;
            margin: 2rem 0;
        }

        .article-content code {
            background: #f8f9fa;
            padding: 0.2rem 0.4rem;
            border-radius: 4px;
            font-size: 0.9em;
            color: #d63384;
        }

        .article-content pre code {
            background: none;
            color: #2c3e50;
            padding: 0;
        }

        .article-content table {
            width: 100%;
            margin: 2rem 0;
            border-collapse: collapse;
        }

        .article-content th,
        .article-content td {
            padding: 0.75rem;
            border: 1px solid #dee2e6;
        }

        .article-content th {
            background: #f8f9fa;
            font-weight: 600;
        }

        .hover-text-primary:hover {
            color: #0d6efd !important;
        }

        /* Адаптивность */
        @media (max-width: 768px) {
            .display-4 {
                font-size: 2.5rem;
            }

            .d-flex.justify-content-center.gap-4 {
                flex-wrap: wrap;
                gap: 1rem !important;
            }
        }

        /* Дополнительные стили для комментариев */
        .card {
            transition: box-shadow 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .border-start {
            border-left-width: 2px !important;
            border-left-color: #dee2e6 !important;
        }
    </style>
@endpush

@push('js')
    <script>
        function replyTo(id) {
            document.getElementById('reply-form-' + id).classList.remove('d-none');
        }

        function cancelReply(id) {
            document.getElementById('reply-form-' + id).classList.add('d-none');
        }

        function editComment(id) {
            document.getElementById('edit-form-' + id).classList.remove('d-none');
        }

        function cancelEdit(id) {
            document.getElementById('edit-form-' + id).classList.add('d-none');
        }
    </script>
@endpush
