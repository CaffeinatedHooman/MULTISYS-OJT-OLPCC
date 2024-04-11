<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $users = [
            [
                'name' => 'King Ramones',
                'email' => 'kingramones@gmail.com',
                'password' => bcrypt('sample'),
            ]
        ];

        foreach ($users as $userData) {
            // Create a new User model instance
            $user = new User();

            $user->name = $userData['name'];
            $user->email = $userData['email'];
            $user->password = $userData['password'];

            $user->save();
        }
    }
}
