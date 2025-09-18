<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'boite.sphinx@example.com'],
            [
                'name' => 'Boite Sphinx',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->call(PuppySeeder::class);
    }
}
