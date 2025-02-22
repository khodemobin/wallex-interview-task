<?php

namespace Feature\UserController;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;


class UpdateTest extends TestCase
{
    public function test_user_update_success(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/users', [
            "profile_photo" => UploadedFile::fake()->image('avatar.jpg')
        ]);

        $response->assertStatus(200);

        $photo = $response->json()["data"]["profile_photo"];
        $path = explode("/",$photo)[4];
        Storage::disk('public')->assertExists($path);

        $this->assertEquals($user->mobile, $response->json()["data"]["mobile"]);
    }


    public function test_user_me_validation_failed(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/users', [
            "profile_photo" => UploadedFile::fake()->image('avatar.pdf')
        ]);

        $response->assertStatus(422);
    }
}
