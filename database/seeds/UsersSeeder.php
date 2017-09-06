<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => "Dejan Stosic",
            'email' => "admin@admin.com",
            'password' => bcrypt("123123"),
            'role' => "0"
        ]);
    }
}
