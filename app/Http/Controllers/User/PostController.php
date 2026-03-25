<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()
            ->where('user_id', auth()->id())
            ->paginate(10);

        return view('user.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('user.posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'content' => ['required', 'string', 'max:10000'],
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published' => ['nullable', 'boolean'],
        ]);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
        }
        $post = Post::query()->create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'published' => $validated['published'],
            'image' => $path,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('user.posts.show', $post);
    }

    public function show(Post $post)
    {
        return view('user.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('user.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if (($post->user_id !== Auth::id()) && ! auth()->user()->is_admin) {
            abort(403);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
        }
        $data['published'] = $request->has('published');
        $data['image'] = $path ?? $post->image;
        $post->update($data);

        return redirect()->route('user.posts.show', $post)->with('success', 'Пост обновлён');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('user.posts')->with('success', 'Пост удалён');
    }
}
