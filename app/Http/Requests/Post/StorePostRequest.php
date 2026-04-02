<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'content' => ['required', 'string', 'max:10000'],
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published' => ['nullable', 'boolean'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Поле "Заголовок" обязательно для заполнения.',
            'title.string' => 'Заголовок должен быть строкой.',
            'title.max' => 'Заголовок не должен превышать :max символов.',

            'content.required' => 'Поле "Содержимое" обязательно для заполнения.',
            'content.string' => 'Содержимое должно быть строкой.',
            'content.max' => 'Содержимое не должно превышать :max символов.',

            'image.required' => 'Изображение обязательно для загрузки.',
            'image.image' => 'Загруженный файл должен быть изображением.',
            'image.mimes' => 'Изображение должно быть одного из форматов: :values.',
            'image.max' => 'Размер изображения не должен превышать :max килобайт.',

            'published.boolean' => 'Поле "Опубликовано" должно быть истинным или ложным.',
        ];
    }
}
