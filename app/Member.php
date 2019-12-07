<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [

        'name', 'address', 'phone_number', 'mottoes', 'img'

    ];

    // User와 Member는 1:1 관계
    public function user() {
        return $this->hasOne(User::class);
    }
}
