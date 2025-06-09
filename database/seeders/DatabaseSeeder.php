<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(RoleSeeder::class);

        $adminRole = Role::where('name', 'Administrador')->first();
        $password = env('ADMIN_PASSWORD', 'password');

        User::factory()->create([
            'name' => 'André Jálisson',
            'email' => 'andrejalisson@sgroupnacional.com.br',
            'password' => Hash::make($password),
            'role_id' => $adminRole?->id,
        ]);
    }
}
