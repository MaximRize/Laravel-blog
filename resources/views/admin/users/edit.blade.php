@extends('layouts.admin')

@section('title', 'Редактирование пользователя')

@section('admin.content')
    <x-title>
        {{ __('Редактирование пользователя') }} #{{ $user->id }}
        <x-slot name="link">
            <a href="{{ route('admin.users') }}">{{ __('Назад к списку') }}</a>
        </x-slot>
    </x-title>

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Имя') }}</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_admin">{{ __('Администратор') }}</label>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="active" name="active" value="1" {{ old('active', $user->active) ? 'checked' : '' }}>
            <label class="form-check-label" for="active">{{ __('Активен (не забанен)') }}</label>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Сохранить') }}</button>
    </form>
@endsection
