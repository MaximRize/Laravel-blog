<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:30', 'alpha_num', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:3', 'max:50', 'confirmed'],
            'agreement' => ['accepted'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'name.max' => 'Имя не должно превышать :max символов.',
            'name.alpha_num' => 'Имя может содержать только буквы и цифры.',
            'name.unique' => 'Это имя уже занято.',

            'email.required' => 'Поле "Email" обязательно для заполнения.',
            'email.email' => 'Введите корректный email адрес.',
            'email.unique' => 'Этот email уже зарегистрирован.',

            'password.required' => 'Поле "Пароль" обязательно для заполнения.',
            'password.min' => 'Пароль должен содержать минимум :min символов.',
            'password.max' => 'Пароль не должен превышать :max символов.',
            'password.confirmed' => 'Подтверждение пароля не совпадает.',

            'agreement.accepted' => 'Вы должны согласиться с условиями.',
        ];
    }
}
