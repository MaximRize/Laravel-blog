<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

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

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $path = $request->file('image')->store('uploads', 'public');

        $data['published'] = $request->boolean('published');
        $data['image'] = $path;
        $data['user_id'] = auth()->id();
        $post = Post::query()->create($data);

        return redirect()->route('user.posts.show', $post);
    }

    public function show(Post $post)
    {
        $user = auth()->user();
        abort_if($post->user_id !== $user->id && !$user->is_admin, 403);
        return view('user.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $user = auth()->user();
        abort_if($post->user_id !== $user->id && !$user->is_admin, 403);
        return view('user.posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($post->image);
            $path = $request->file('image')->store('uploads', 'public');
            $data['image'] = $path;
        }
        $data['published'] = $request->boolean('published');
        $post->update($data);

        return redirect()->route('user.posts.show', $post)->with('success', 'Пост обновлён');
    }

    public function destroy(Post $post)
    {
        abort_if($post->user_id !== auth()->id() && !auth()->user()->is_admin, 403);
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->back()->with('success', 'Пост удалён');
    }
}
