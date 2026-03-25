<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:1',
        ], [
            'email.required' => 'Поле email обязательно',
            'email.email' => 'Введите корректный email',
            'password.required' => 'Поле password обязательно',
            'password.min' => 'Пароль должен быть минимум 8 символов',
        ]);

        if (Auth::attempt($credentials)) {
            session()->flash('alert', __('Добро пожаловать'));

            return redirect()->route('user.posts');
        }

        return back()->withInput()
            ->with('danger', __('Неверный email или пароль'));
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
