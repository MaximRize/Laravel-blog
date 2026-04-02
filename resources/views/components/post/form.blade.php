@props(['post' => null])

<x-form method="POST" {{ $attributes->except('method') }} enctype="multipart/form-data">
    @if($attributes->get('method') === 'PUT')
        @method('PUT')
    @endif


    <x-form-item>
        <x-label required>{{ __('Название поста') }}</x-label>
        <x-input
            name="title"
            value="{{ old('title', $post->title ?? '') }}"
            autofocus
            required
        />
        <x-error name="title"/>
    </x-form-item>


    <x-form-item>
        <x-label required>{{ __('Содержание поста') }}</x-label>
        <x-trix
            name="content"
            value="{{ old('content', $post->content ?? '') }}"
        />
        <x-error name="content"/>
    </x-form-item>


    <x-form-item>
        <x-label>{{ __('Изображение (обложка)') }}</x-label>
        <input
            type="file"
            name="image"
            id="image"
            class="form-control @error('image') is-invalid @enderror"
            accept="image/*"
        >
        <x-error name="image"/>

        @if($post && $post->image)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $post->image) }}" alt="Preview"
                     style="max-height: 150px; border-radius: 8px;">
            </div>
        @endif
    </x-form-item>


    <x-form-item>
        <div class="form-check">
            <input
                type="checkbox"
                name="published"
                id="published"
                class="form-check-input"
                value="1"
                {{ old('published', $post->published ?? true) ? 'checked' : '' }}
            >
            <label for="published" class="form-check-label">
                {{ __('Опубликован (виден всем)') }}
            </label>
        </div>
        <x-error name="published"/>
    </x-form-item>


    <div class="mt-4">
        <x-button type="submit">
            {{ $slot }}
        </x-button>
    </div>
</x-form>
