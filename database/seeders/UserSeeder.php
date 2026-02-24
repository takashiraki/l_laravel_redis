<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('SEED_USER_EMAIL', 'admin@example.com');

        if (User::where('email', $email)->exists()) {
            $this->command->warn("User [{$email}] already exists. Skipping.");
            return;
        }

        User::create([
            'name'     => env('SEED_USER_NAME', 'Admin'),
            'email'    => $email,
            'password' => env('SEED_USER_PASSWORD', 'password'),
        ]);

        $this->command->info("User [{$email}] created successfully.");
    }
}
