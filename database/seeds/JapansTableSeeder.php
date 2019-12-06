<?php

use Illuminate\Database\Seeder;

class JapansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Japan::create([
            'img' => '',
            'place' => 'TEST_PLACE',
            'explain' => 'TEST_EXPLAIN',
          ]);
    }
}
