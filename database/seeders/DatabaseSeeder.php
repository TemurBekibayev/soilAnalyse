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
        $user = User::where('email', 'test@example.com')->first();
        
        if (!$user) {
            $user = new User();
            $user->name = 'Test User';
            $user->email = 'test@example.com';
            $user->password = bcrypt('password');
            $user->email_verified_at = now();
            $user->save();
        }
    }
}
