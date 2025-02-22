<?php

namespace Feature\AuthController;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;


class LoginTest extends TestCase
{
    public function test_login_success(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/auth/login', [
            'mobile' => $user->mobile,
            "password" => "password"
        ]);

        $response->assertStatus(200);

        $response->assertJson(fn(AssertableJson $json) => ($json->has('data.access_token')->etc()));
        $this->assertEquals($user->mobile, $response->json()["data"]["user"]["mobile"]);
    }


    /**
     * A basic test example.
     */
    public function test_login_failed(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/auth/login', [
            'mobile' => $user->mobile,
            "password" => "password1"
        ]);

        $response->assertStatus(422);
    }
}
