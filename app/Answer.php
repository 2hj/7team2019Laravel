<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'a_id', 'target_id', 'answer_title', 'answer_content'
    ];

    public function question() {
        // question과 1:1 관계
        return $this->hasOne(Answer::class);
    }

    // 2019-11-28 question과의 관계 외 user와의 관계 삭제
}
