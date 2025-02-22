<?php

namespace Feature\PostController;

use App\Models\Post;
use Tests\TestCase;


class ShowTest extends TestCase
{
    public function test_post_show_success(): void
    {
        $post = Post::factory()->create();
        $views = $post->view_count;

        $response = $this->actingAs($post->user)->getJson("/api/posts/{$post->id}");

        $response->assertStatus(200);

        $this->assertEquals($post->title, $response->json()["data"]["title"]);

        $this->assertDatabaseHas("posts", [
            "id" => $post->id,
            "view_count" => $views + 1
        ]);

        $this->assertDatabaseHas("post_views", [
            "post_id" => $post->id,
        ]);
    }

    public function test_user_posts_failed(): void
    {
        $response = $this->getJson('/api/posts/1');
        $response->assertStatus(401);
    }
}
