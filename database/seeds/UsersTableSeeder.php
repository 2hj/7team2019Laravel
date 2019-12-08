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
        // admin 유저 시더
        App\User::create([
            'name' => 'ADMIN',
            'email' => 'root@php.com',
            'password' => bcrypt('password'),
            'admin'=>1,
        ]);

        // 일반사용자 시더
        App\User::create([
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => bcrypt('testtest'),
            'admin'=>0,
        ]);

        factory(App\User::class)->create(['email'=>'user@php.com']);

    }
}
