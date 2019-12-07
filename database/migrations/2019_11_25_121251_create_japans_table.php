<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJapansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // img, place, explain, created_at, updated_at
        Schema::create('japans', function (Blueprint $table) {
            //$table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->string('img', 255)->nullable();
            $table->text('place');
            $table->text('explain');

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
        Schema::dropIfExists('japans');
    }
}
