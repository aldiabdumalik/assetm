<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Regional;
use App\Models\User;
use App\Models\UserInfo;
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
            'name' => 'Akun Admin Ganteng',
            'username'=> 'admin.ganteng',
            'email'=> 'admin.ganteng@gmail.com',
            'photo'=> 'default.jpg',
            'level'=> 1,
            'password' => bcrypt('12345678')
        ]);

        $reg = Regional::create([
            'regional_name' => 'JAWA BARAT'
        ]);

        $branch = Branch::create([
            'regional_id' => $reg->id,
            'branch_name' => 'KARAWANG'
        ]);

        $info = UserInfo::create([
            'user_id' => $user->id,
            'branch_id' => $branch->id,
        ]);

    }
}
