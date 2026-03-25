@props(['post'])

<div class="card h-100 border-0 shadow-sm hover-shadow transition">
    @if($post->image)
        <img src="{{ asset('storage/' . $post->image) }}"
             class="card-img-top"
             alt="{{ $post->title }}"
             style="height: 180px; object-fit: cover;">
    @else
        <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
             style="height: 180px;">
            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
        </div>
    @endif

    <div class="card-body d-flex flex-column">
        <h5 class="card-title fw-bold mb-2">
            <a href="{{ route('blog.show', $post) }}" class="text-decoration-none text-dark stretched-link">
                {{ $post->title }}
            </a>
        </h5>

        <p class="card-text text-muted small mb-3 flex-grow-1">
            {{ Str::limit(strip_tags($post->content), 80) }}
        </p>

        <!-- Первая строка: автор и дата (без времени) -->
        <div class="d-flex justify-content-between align-items-center mb-1">
            <div class="d-flex align-items-center text-muted small" style="min-width: 0; flex: 1;">
                <i class="bi bi-person me-1 flex-shrink-0"></i>
                <span class="text-truncate" style="max-width: 120px;">
                    {{ $post->user->name ?? 'Неизвестный автор' }}
                </span>
            </div>
            <div class="d-flex align-items-center text-muted small ms-2 flex-shrink-0">
                <i class="bi bi-calendar3 me-1"></i>
                <span>{{ $post->created_at->format('d.m.Y') }}</span>
            </div>
        </div>

        <!-- Вторая строка: время и относительная дата с иконкой часов -->
        <div class="d-flex align-items-center text-muted small">
            <i class="bi bi-clock me-1 flex-shrink-0"></i>
            <span class="js-local-time" data-utc="{{ $post->created_at->timestamp }}"></span>
            <span class="ms-1">({{ $post->created_at->diffForHumans() }})</span>
        </div>

        @if($post->tags && $post->tags->count() > 0)
            <div class="mt-2 pt-2 border-top">
                @foreach($post->tags->take(2) as $tag)
                    <span class="badge bg-light text-dark me-1">
                        <i class="bi bi-tag me-1"></i>
                        {{ $tag->name }}
                    </span>
                @endforeach
                @if($post->tags->count() > 2)
                    <span class="badge bg-light text-dark">
                        +{{ $post->tags->count() - 2 }}
                    </span>
                @endif
            </div>
        @endif
    </div>
</div>
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.js-local-time').forEach(function(el) {
                const timestamp = el.dataset.utc; // Unix timestamp из атрибута
                if (timestamp) {
                    const date = new Date(timestamp * 1000); // переводим в миллисекунды
                    // Форматируем локально: часы и минуты
                    const hours = date.getHours().toString().padStart(2, '0');
                    const minutes = date.getMinutes().toString().padStart(2, '0');
                    el.textContent = hours + ':' + minutes;
                }
            });
        });
    </script>
@endpush
