<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'username'=> 'admin.ganteng',
            'email'=> 'admin.ganteng@gmail.com',
            'photo'=> 'default.jpg',
            'level'=> 1,
            'password' => bcrypt('12345678')
        ]);
    }
}
