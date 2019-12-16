<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'admin'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // $casts : 모델에서 데이터 조회 시 자동으로 타입 변환(캐스팅)할 목록 

    public function isAdmin(){
      return ($this->admin === 1) ? true : false;
    }

    public function member() {
        return $this->hasOne(Member::class);
    }

    public function questions() {
        return $this->hasMany(Question::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }
}
