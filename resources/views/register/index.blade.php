@extends('layouts.auth')
@section('name','Регистрация')


@section('auth.content')
    <x-card>
        <x-card-header>
            <x-card-title>
                {{__('Регистрация')}}
            </x-card-title>

            <x-slot name="right">
                <a href="{{ route('login') }}">
                    {{ __('Вход') }}
                </a>
            </x-slot>
        </x-card-header>

        <x-card-body>
            <x-form action="{{route('register.store')}}" method="POST">
                <x-form-item>
                    <x-label required> {{__('Имя')}}</x-label>
                    <x-input name="name" value="{{ old('name') }}" autofocus></x-input>
                    <x-error name="name" />
                </x-form-item>

                <x-form-item>
                    <x-label required> {{__('Почта')}}</x-label>
                    <x-input type="email" value="{{ old('email') }}" name="email"></x-input>
                    <x-error name="email" />
                </x-form-item>

                <x-form-item>
                    <x-label required> {{__('Пароль')}}</x-label>
                    <x-input type="password"  name="password"></x-input>
                    <x-error name="password" />
                </x-form-item>

                <x-form-item>
                    <x-label required> {{__('Повторите пароль')}}</x-label>
                    <x-input type="password"  name="password_confirmation"></x-input>
                    <x-error name="password_confirmation" />
                </x-form-item>

                <x-form-item>
                    <x-checkbox name="agreement">
                        {{__('Я согласен на обработку персональных данных')}}
                    </x-checkbox>
                    <x-error name="agreement" />
                </x-form-item>

                <x-button type="submit" color="success">
                    {{__('Зарегистировать')}}
                </x-button>

            </x-form>
        </x-card-body>
    </x-card>
@endsection


