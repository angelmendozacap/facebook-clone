<?php

namespace App\Http\Controllers;

use App\Post;
use App\Friend;
use App\Http\Resources\PostCollection;
use App\Http\Resources\Post as PostResource;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function index()
    {
        $friends = Friend::friendships();

        if ($friends->isEmpty()) return new PostCollection(request()->user()->posts);

        return new PostCollection(
            Post::whereIn('user_id', [
                $friends->pluck('user_id'),
                $friends->pluck('friend_id')
            ])->get()
        );
    }

    public function store()
    {
        $data = request()->validate([
            'body' => ''
        ]);

        $post = request()->user()->posts()->create($data);

        return new PostResource($post);
    }
}
