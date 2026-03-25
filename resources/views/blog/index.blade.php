@extends('layouts.main')
@section('title', 'Список постов')

@section('main.content')
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 fw-bold mb-0">
                <i class="bi bi-pencil-square me-2"></i>
                {{__('Список постов')}}
            </h1>

            <div class="text-muted">
                <i class="bi bi-file-text me-1"></i>
                {{ $posts->total() }} {{ __('постов') }}
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                @include('blog.filter')
            </div>
        </div>

        @if ($posts->isEmpty())
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                </div>
                <h3 class="h4 text-muted">{{__('Нет ни одного поста.')}}</h3>
                <p class="text-muted">{{ __('Попробуйте изменить параметры поиска') }}</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($posts as $post)
                    <div class="col-12 col-md-6 col-lg-4">
                        <x-post.card :post="$post"/>
                    </div>
                @endforeach
            </div>


            <div class="d-flex justify-content-center mt-5">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection
