<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(User $user)
    {
        $users = $user->query()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('posts');

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'active' => 'nullable',
        ]);
        $validated['active'] = $request->has('active') ? 1 : 0;
        $user->update($validated);

        return redirect()->route('admin.users');
    }

    public function destroy(User $user, Request $request)
    {
        return redirect()->route('admin.users');
    }
}
