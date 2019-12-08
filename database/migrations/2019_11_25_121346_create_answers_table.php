<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // user_mail, user_name, admin, target_id, created_at, updated_at
        Schema::create('answers', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            // $table->integer('a_id')->unsigned()->index();
            // 2019-11-28 응답 제목, 내용 추가
            // $table->string('answer_title', 255);
            $table->text('answer_content');
            
            $table->timestamps();            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
