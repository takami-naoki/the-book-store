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
            'name' => 'Pace Creative',
            'email' => 'test@gmail.com',
            'password' => bcrypt('11111111'),
            'api_token' => \Illuminate\Support\Str::random(32),
        ]);
    }
}
