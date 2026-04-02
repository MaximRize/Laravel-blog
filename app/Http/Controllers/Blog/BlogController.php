<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'min:1', 'max:50'],
            'fromDate' => ['nullable', 'string', 'date'],
            'toDate' => ['nullable', 'string', 'date', 'after:fromDate', 'before_or_equal:today'],
        ]);

        $posts = Post::query()
            ->with('user', 'comments')
            ->when($validated['search'] ?? null, function (Builder $query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->when($validated['fromDate'] ?? null, function (Builder $query, $fromDate) {
                $query->whereDate('created_at', '>=', "$fromDate");
            })
            ->when($validated['toDate'] ?? null, function (Builder $query, $toDate) {
                $query->whereDate('created_at', '<=', "$toDate");
            })
            ->where('published', true)
            ->latest('created_at')
            ->paginate(12)
            ->withQueryString();
        $minPostDate = Carbon::parse(Post::query()->min('created_at'))->format('Y-m-d');

        return view('blog.index', compact('posts', 'minPostDate'));
    }

    public function show(Post $post)
    {
        return view('blog.show', compact('post'));
    }
}
