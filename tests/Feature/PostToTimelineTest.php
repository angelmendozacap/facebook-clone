<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostToTimelineTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_post_a_text_post()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $response = $this->post('/api/posts', [
            'data' => [
                'type' => 'posts',
                'attributes' => [
                    'body' => 'Testing Body'
                ]
            ]
        ]);

        $post = Post::first();

        $this->assertCount(1, Post::all());

        $this->assertEquals($user->id, $post->user_id);
        $this->assertEquals('Testing Body', $post->body);


        $response->assertStatus(Response::HTTP_CREATED)
                    ->assertJson([
                        'data' => [
                            'type' => 'posts',
                            'post_id' => $post->id,
                            'attributes' => [
                                'posted_by' => [
                                    'data' => [
                                        'attributes' => [
                                            'name' => $user->name
                                        ]
                                    ]
                                ],
                                'body' => 'Testing Body'
                            ]
                        ],
                        'links' => [
                            'self' => url('/posts/'.$post->id)
                        ]
                    ]);
    }
}
