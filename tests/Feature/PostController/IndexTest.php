<?php

namespace Feature\PostController;

use App\Models\Post;
use Tests\TestCase;


class IndexTest extends TestCase
{
    public function test_user_posts_success(): void
    {
        $post = Post::factory()->create();
        $response = $this->actingAs($post->user)->getJson('/api/posts');

        $response->assertStatus(200);

        $this->assertNotEmpty($response->json()["data"]);
        $this->assertEquals($post->title, $response->json()["data"][0]["title"]);
        $this->assertEquals($post->user->mobile, $response->json()["data"][0]["user"]["mobile"]);
    }

    public function test_user_posts_failed(): void
    {
        $response = $this->getJson('/api/posts');
        $response->assertStatus(401);
    }
}
