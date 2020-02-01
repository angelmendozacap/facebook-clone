<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_like_a_post()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $post = factory(Post::class)->create([ 'id' => 123 ]);

        $response = $this->post("/api/posts/{$post->id}/like")
            ->assertStatus(Response::HTTP_OK);

        $this->assertCount(1, $user->likedPosts);
        $response->assertJson([
            'data' => [
                [
                    'data' => [
                        'type' => 'likes',
                        'like_id' => 1,
                        'attributes' => []
                    ],
                    'links' => [
                        'self' => url('/posts/123')
                    ]
                ]
            ],
            'links' => [
                'self' => url('/posts')
            ]
        ]);
    }
}
