<x-form method="GET" action="{{ route('blog') }}">
    <div class="row g-3 align-items-end">
        <div class="col-md-4">
            <label for="search" class="form-label fw-semibold">
                <i class="bi bi-search me-1"></i>
                {{ __('Поиск') }}
            </label>
            <x-input
                name="search"
                id="search"
                value="{{ request('search') }}"
                placeholder="{{ __('Поиск по заголовку...') }}"
                class="form-control"
            />
        </div>

        <div class="col-md-3">
            <label for="fromDate" class="form-label fw-semibold">
                <i class="bi bi-calendar-check me-1"></i>
                {{ __('Дата с') }}
            </label>
            <x-input
                type="date"
                id="fromDate"
                name="fromDate"
                value="{{ request('fromDate', $minPostDate ?? '') }}"
                min="{{ $minPostDate ?? '2020-01-01' }}"
                max="{{ now()->format('Y-m-d') }}"
                class="form-control"
            />
        </div>

        <div class="col-md-3">
            <label for="toDate" class="form-label fw-semibold">
                <i class="bi bi-calendar-plus me-1"></i>
                {{ __('Дата по') }}
            </label>
            <x-input
                type="date"
                id="toDate"
                name="toDate"
                value="{{ request('toDate', now()->format('Y-m-d')) }}"
                min="{{ request('fromDate', $minPostDate ?? '') }}"
                max="{{ now()->format('Y-m-d') }}"
                class="form-control"
            />
        </div>

        <div class="col-md-2">
            <x-button type="submit" class="w-100 py-2">
                <i class="bi bi-funnel me-1"></i>
                {{ __('Вперед') }}
            </x-button>
        </div>
    </div>


    @error('fromDate')
    <div class="alert alert-danger mt-3 mb-0 py-2 small">
        <i class="bi bi-exclamation-triangle me-1"></i>
        {{ $message }}
    </div>
    @enderror

    @error('toDate')
    <div class="alert alert-danger mt-2 mb-0 py-2 small">
        <i class="bi bi-exclamation-triangle me-1"></i>
        {{ $message }}
    </div>
    @enderror

    @if(request()->anyFilled(['search', 'fromDate', 'toDate']))
        <div class="d-flex align-items-center mt-3 pt-2 border-top">
            <span class="text-muted small me-2">
                <i class="bi bi-funnel-fill me-1"></i>
                {{ __('Активные фильтры:') }}
            </span>

            <div class="d-flex flex-wrap gap-2">
                @if(request('search'))
                    <span class="badge bg-light text-dark d-inline-flex align-items-center">
                        <i class="bi bi-search me-1"></i>
                        "{{ request('search') }}"
                        <a href="{{ route('blog', array_merge(request()->except('search'), ['page' => null])) }}"
                           class="ms-2 text-danger text-decoration-none">
                            <i class="bi bi-x"></i>
                        </a>
                    </span>
                @endif

                @if(request('fromDate'))
                    <span class="badge bg-light text-dark d-inline-flex align-items-center">
                        <i class="bi bi-calendar-check me-1"></i>
                        {{ __('с') }} {{ request('fromDate') }}
                        <a href="{{ route('blog', array_merge(request()->except('fromDate'), ['page' => null])) }}"
                           class="ms-2 text-danger text-decoration-none">
                            <i class="bi bi-x"></i>
                        </a>
                    </span>
                @endif

                @if(request('toDate'))
                    <span class="badge bg-light text-dark d-inline-flex align-items-center">
                        <i class="bi bi-calendar-plus me-1"></i>
                        {{ __('по') }} {{ request('toDate') }}
                        <a href="{{ route('blog', array_merge(request()->except('toDate'), ['page' => null])) }}"
                           class="ms-2 text-danger text-decoration-none">
                            <i class="bi bi-x"></i>
                        </a>
                    </span>
                @endif

                <a href="{{ route('blog') }}" class="badge bg-secondary text-white text-decoration-none d-inline-flex align-items-center">
                    <i class="bi bi-x-circle me-1"></i>
                    {{ __('Сбросить все') }}
                </a>
            </div>
        </div>
    @endif
</x-form>

@push('styles')
    <style>

        input[type="date"]::-webkit-calendar-picker-indicator {
            opacity: 0.5;
            cursor: pointer;
        }

        input[type="date"]::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
        }

        .badge a:hover {
            opacity: 0.8;
        }

        .btn-primary {
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.getElementById('fromDate')?.addEventListener('change', function() {
            const toDateInput = document.getElementById('toDate');
            if (toDateInput) {
                toDateInput.min = this.value;
            }
        });
    </script>
@endpush
