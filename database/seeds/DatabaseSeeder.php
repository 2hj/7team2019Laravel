<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if(config('database.default') !== 'sqlite'){
          DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }

        App\User::truncate();
        $this->call(UsersTableSeeder::class);

        App\Question::truncate();
        $this->call(QuestionsTableSeeder::class);

        App\Japan::truncate();
        $this->call(JapansTableSeeder::class);

        if(config('database.default') !== 'sqlite'){
          DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
}
