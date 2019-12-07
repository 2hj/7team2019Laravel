<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // user_mail, user_name, admin, address, phone_number, mottoes, created_at, updated_at
        Schema::create('members', function (Blueprint $table) {
            //$table->engine = 'InnoDB';

            $table->bigIncrements('id');
            // 2019-12-02 이름 열 추가
            $table->string('name', 10);
            $table->string('address', 255);
            $table->string('phone_number', 13);
            $table->text('mottoes');
            $table->string('img', 255)->nullable();
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //onDelete(cascade) : cascade는 '종속'이라는 뜻. 즉 참조하고있는 users테이블 데이터가 삭제되면 해당 member도 삭제 된다는 뜻

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
        Schema::dropIfExists('members');
    }
}
