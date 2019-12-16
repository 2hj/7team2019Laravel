<?php

use Illuminate\Database\Seeder;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      App\Member::create([
        'name'=>'이혜진',
        'address'=>'복현동',
        'phone_number'=>'010-5526-9966',
        'mottoes'=>'취업하고싶다~',
        'img'=>null,
      ]);
    }
}
