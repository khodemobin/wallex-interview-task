<?php

namespace Feature\UserController;

use App\Models\User;
use App\Services\PostService;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;


class IndexTest extends TestCase
{
    public function test_user_list_success(): void
    {
        $response = $this->getJson('/api/users');

        $response->assertStatus(200);
    }
}
