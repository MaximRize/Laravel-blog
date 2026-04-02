<?php

use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Posts\CommentController;

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/{post}/like', [BlogController::class, 'like'])->name('blog.like');
Route::post('/blog/{post}', [CommentController::class, 'store'])->name('comments.store');

Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
