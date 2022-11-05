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
            'name'=>'User',
            'username'=>'admin@admin.com',
            'email'=>'admin@admin.com',
            'is_admin'=>true,
            'password'=>bcrypt('password')
        ]);
    }
}
