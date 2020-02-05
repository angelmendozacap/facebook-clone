<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Resources\CommentCollection;

class PostCommentController extends Controller
{
    public function store(Post $post)
    {
        $data = request()->validate([
            'body' => 'required'
        ]);

        $post->comments()->create(array_merge($data, [
            'user_id' => auth()->user()->id
        ]));

        return new CommentCollection($post->comments);
    }
}
