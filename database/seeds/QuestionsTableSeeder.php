<?php

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      App\Question::create([
        'user_id' => 1,
        'title' => 'TEST_TITLE',
        'content' => 'TEST_CONTENT',
      ]);

      App\Question::create([
          'user_id' => 2,
          'title' => 'TEST_SECOND_TITLE',
          'content' => 'TEST_SECOND_CONTENT',
      ]);

      App\Question::create([
          'user_id' => 1,
          'title' => 'TEST_THIRD_TITLE',
          'content' => 'TEST_THIRD_CONTENT',
      ]);

      App\Question::create([
          'user_id' => 2,
          'title' => 'TEST_FORTH_TITLE',
          'content' => 'TEST_FORTH_CONTENT',
      ]);
    }
}
