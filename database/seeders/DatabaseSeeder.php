<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Website;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@bytesoftware.io',
            'password' => bcrypt('password'),
        ]);

        Website::factory()->create([
            'name' => 'ByteSoftware',
            'domain' => app()->isLocal() ? '127.0.0.1' : 'bytesoftware.io',
            'uuid' => Str::uuid(),
        ]);
    }
}
