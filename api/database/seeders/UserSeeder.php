<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Seeding user table

        User::truncate();

        $users = [
            [
                'name' => 'Leona Kingswell',
                'email' => 'test.user1@gmail.com',
                'password' => Hash::make('test123'),
                'role' => 'User',
            ],
            [
                'name' => 'Fanchon Korlat',
                'email' => 'test.user2@gmail.com',
                'password' => Hash::make('test123'),
                'role' => 'User',
            ],
            [
                'name' => 'Florence Clifft',
                'email' => 'test.user3@gmail.com',
                'password' => Hash::make('test123'),
                'role' => 'User',
            ],
            [
                'name' => 'Ruy Chatteris',
                'email' => 'test.user4@gmail.com',
                'password' => Hash::make('test123'),
                'role' => 'User',
            ],
            [
                'name' => 'Babs Martusov',
                'email' => 'test.user5@gmail.com',
                'password' => Hash::make('test123'),
                'role' => 'User',
            ],
            [
                'name' => 'Babs Martusov',
                'email' => 'test.admin@gmail.com',
                'password' => Hash::make('test123'),
                'role' => 'Admin',
            ]
        ];

        User::insert($users);
    }
}
