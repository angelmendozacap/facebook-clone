<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Resources\PostCollection;
use App\Http\Resources\Post as PostResource;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function index()
    {
        return new PostCollection(Post::all());
    }

    public function store()
    {
        $data = request()->validate([
            'data.attributes.body' => ''
        ]);

        $post = request()->user()->posts()->create($data['data']['attributes']);

        return new PostResource($post);
    }
}
