<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_role_can_be_created(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('roles.store'), [
            'name' => 'Test Role',
        ]);

        $response->assertRedirect(route('roles.index', absolute: false));
        $this->assertDatabaseHas('roles', ['name' => 'Test Role']);
    }

    public function test_role_can_be_updated(): void
    {
        $user = User::factory()->create();
        $role = Role::factory()->create(['name' => 'Old Name']);

        $response = $this->actingAs($user)->put(route('roles.update', $role), [
            'name' => 'New Name',
        ]);

        $response->assertRedirect(route('roles.index', absolute: false));
        $this->assertDatabaseHas('roles', ['id' => $role->id, 'name' => 'New Name']);
    }

    public function test_role_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $response = $this->actingAs($user)->delete(route('roles.destroy', $role));

        $response->assertRedirect(route('roles.index', absolute: false));
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }
}
