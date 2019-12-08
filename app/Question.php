<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'title', 'content', 'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function answer() {
        // answer과 1:1 관계
        return $this->belongsTo(Answer::class);
    }

    // 2019-11-28 User와의 관계 삭제
}
