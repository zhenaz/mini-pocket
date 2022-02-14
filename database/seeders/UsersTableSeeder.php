<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'role_id' => '1',
            'email' => 'admin@gmail.com',
            'address' => 'Cibinong',
            'password' => bcrypt('admin'),
        ]);
    }
}
