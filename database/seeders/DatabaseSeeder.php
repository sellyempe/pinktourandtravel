<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@pinktravel.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // Test User
        User::factory()->create([
             'name' => 'John Doe',
            'email' => 'user@pinktravel.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        $this->call([
            CompanySettingSeeder::class,
            DestinationSeeder::class,
            TripSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}