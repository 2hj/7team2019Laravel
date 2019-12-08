<?php

use Illuminate\Database\Seeder;

class AnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Answer::create([
            'target_id' => 1,
            'answer_content' => 'TEST_CONTENT',
        ]);

        App\Answer::create([
            'target_id' => 2,
            'answer_content' => 'TEST_CONTENT',
        ]);

        App\Answer::create([
            'target_id' => 3,
            'answer_content' => 'TEST_CONTENT',
        ]);

        App\Answer::create([
            'target_id' => 4,
            'answer_content' => 'TEST_CONTENT',
        ]);
    }
}
