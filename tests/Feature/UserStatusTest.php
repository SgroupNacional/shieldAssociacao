<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_status_can_be_toggled(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create(['status' => true]);

        $response = $this->actingAs($admin)->post(route('users.toggle-status', $user));

        $response->assertOk();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'status' => false,
        ]);
    }

    public function test_deleted_user_does_not_appear_in_listing(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($admin)->delete(route('users.destroy', $user));

        $response = $this->actingAs($admin)->post(route('users.listar'), [
            'start' => 0,
            'length' => 10,
            'draw' => 1,
            'order' => [['column' => 0, 'dir' => 'asc']],
        ]);

        $response->assertOk();
        $response->assertJsonMissing(['id' => $user->id]);
    }
}
