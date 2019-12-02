<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RetrievePostsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_retrieve_posts()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');
        $posts = factory(Post::class, 2)->create([
            'user_id' => $user->id
        ]);

        $response = $this->get('/api/posts');
        dd($posts->last()->image);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'data' => [
                    [
                        'data' => [
                            'type' => 'posts',
                            'post_id' => $posts->last()->id,
                            'attributes' => [
                                'body' => $posts->last()->body,
                                'posted_at' => $posts->last()->created_at->diffForHumans(),
                                'image' => $posts->last()->image
                            ]
                        ]
                    ],
                    [
                        'data' => [
                            'type' => 'posts',
                            'post_id' => $posts->first()->id,
                            'attributes' => [
                                'body' => $posts->first()->body,
                                'posted_at' => $posts->first()->created_at->diffForHumans(),
                                'image' => $posts->first()->image
                            ]
                        ]
                    ]
                ],
                'links' => [
                    'self' => url('/posts')
                ]
            ]);
    }

    /** @test */
    public function a_user_can_only_retrieve_their_posts()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $posts = factory(Post::class)->create();

        $response = $this->get('/api/posts');

        $response->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'data' => [],
                'links' => [
                    'self' => url('/posts')
                ]
            ]);
    }
}
