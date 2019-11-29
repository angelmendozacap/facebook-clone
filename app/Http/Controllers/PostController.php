<?php

namespace App\Http\Controllers;

use App\Post;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'data.attributes.body' => ''
        ]);

        $post = request()->user()->posts()->create($data['data']['attributes']);

        return response([
            'data' => [
                'type' => 'posts',
                'post_id' => $post->id,
                'attributes' => [
                    'body' => $post->body
                ]
            ],
            'links' => [
                'self' => url('/posts/'.$post->id)
            ]
        ], Response::HTTP_CREATED);
    }
}
