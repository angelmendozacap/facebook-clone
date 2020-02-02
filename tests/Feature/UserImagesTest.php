<?php

namespace Tests\Feature;

use App\User;
use App\UserImage;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserImagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    /** @test */
    public function images_can_be_uploaded()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $file = UploadedFile::fake()->image('user_image.jpg');

        $response = $this->post('/api/user-images', [
            'image' => $file,
            'width' => 850,
            'height' => 300,
            'location' => 'cover'
        ])->assertStatus(Response::HTTP_CREATED);

        Storage::disk('public')->assertExists("user-images/{$file->hashName()}");

        $userImage = UserImage::first();

        $this->assertEquals("user-images/{$file->hashName()}", $userImage->path);
        $this->assertEquals(850, $userImage->width);
        $this->assertEquals(300, $userImage->height);
        $this->assertEquals('cover', $userImage->location);
        $this->assertEquals($user->id, $userImage->user_id);

        $response->assertJson([
            'data' => [
                'type' => 'user_images',
                'user_image_id' => $userImage->id,
                'attributes' => [
                    'path' => url("/storage/{$userImage->path}"),
                    'width' => $userImage->width,
                    'height' => $userImage->height,
                    'location' => $userImage->location
                ]
            ],
            'links' => [
                'self' => url("/users/{$user->id}")
            ]
        ]);
    }

    /** @test */
    public function user_are_returned_with_their_images()
    {
        $this->withoutExceptionHandling();

        $file = UploadedFile::fake()->image('user_image.jpg');
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $this->post('/api/user-images', [
            'image' => $file,
            'width' => 850,
            'height' => 300,
            'location' => 'cover'
        ])->assertStatus(Response::HTTP_CREATED);

        $this->post('/api/user-images', [
            'image' => $file,
            'width' => 850,
            'height' => 300,
            'location' => 'profile'
        ])->assertStatus(Response::HTTP_CREATED);

        $response = $this->get("/api/users/{$user->id}");

        $response->assertJson([
            'data' => [
                'type' => 'users',
                'user_id' => $user->id,
                'attributes' => [
                    'cover_image' => [
                        'data' => [
                            'type' => 'user_images',
                            'user_image_id' => 1,
                            'attributes' => []
                        ]
                    ],
                    'profile_image' => [
                        'data' => [
                            'type' => 'user_images',
                            'user_image_id' => 2,
                            'attributes' => []
                        ]
                    ]
                ]
            ]
        ]);
    }
}
