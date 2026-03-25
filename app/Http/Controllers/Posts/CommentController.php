<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
    }

    public function store(Request $request, Post $post)
    {
        $data = $request->validate([
                'body'=>['required','string','min:1', 'max:1000'],
                'parent_id' => ['nullable', 'exists:comments,id'],

            ]);
        $comment=Comment::create([
            'body'=>$data['body'],
            'user_id'=>auth()->id(),
            'post_id'=>$post->id,
            'parent_id' => $data['parent_id'] ?? null,
        ]);
        return back();
    }
    public function update(Comment $comment, Request $request)
    {
        $data = $request->validate([
            'body'=>['required','string','min:1', 'max:1000'],
            ]);
        $comment->update($data);
        return back();
    }
    public function destroy(Comment $comment)
    {
    $comment->delete();
    return back();
    }
}
