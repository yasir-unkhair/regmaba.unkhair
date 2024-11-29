<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            'name' => 'Muhamad Yasir',
            'email' => 'iryas@admin.com',
            'username' => 'yasir@admin',
            'password' => Hash::make('109696'),
            'user_simak' => 0,
            'is_active' => 1
        ];

        User::create($users);
    }
}
