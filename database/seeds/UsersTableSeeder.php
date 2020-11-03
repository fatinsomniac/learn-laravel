<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'Dede Dwi Narantika',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'email' => 'narantikadwi16@gmail.com',
        ]);
    }
}
