<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'is_admin' => true
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test2@example.com',
        ]);

        Listing::factory(50)->create(['by_user_id' => 1]);
        Listing::factory(50)->create(['by_user_id' => 2]);
    }
}
