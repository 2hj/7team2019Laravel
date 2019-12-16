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
      App\Member::create([
        'name'=>'김승준',
        'address'=>'복현동',
        'phone_number'=>'010-0000-0000',
        'mottoes'=>'김승준 좌우명',
        'img'=>null,
      ]);
      App\Member::create([
        'name'=>'윤시훈',
        'address'=>'복현동',
        'phone_number'=>'010-0000-0000',
        'mottoes'=> '윤시훈 좌우명',
        'img'=>null,
      ]);
      App\Member::create([
        'name'=>'이상민',
        'address'=>'복현동',
        'phone_number'=>'010-0000-0000',
        'mottoes'=>'이상민 좌우명',
        'img'=>null,
      ]);
      App\Member::create([
        'name'=>'임성훈',
        'address'=>'복현동',
        'phone_number'=>'010-0000-0000',
        'mottoes'=>'임성훈 좌우명',
        'img'=>null,
      ]);
    }
}
