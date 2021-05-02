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
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123'),
            'active' => true
        ]);
        $user->assignRole('Administrador');

        $usert = User::create([
            'name' => 'User One',
            'email' => 'userone@gmail.com',
            'password' => bcrypt('123'),
            'active' => true
            ]);
        $usert->assignRole('Usuario');

        $usertt = User::create([
            'name' => 'User Two',
            'email' => 'usertwo@gmail.com',
            'password' => bcrypt('123'),
            'active' => true
            ]);
        $usertt->assignRole('Usuario');
    }
}
