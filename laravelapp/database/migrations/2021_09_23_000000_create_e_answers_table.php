<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_answers', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->biginteger('user_id');
          $table->integer('s_id');
          $table->integer('no');
          $table->integer('q_no');
          $table->integer('correct');
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
        Schema::dropIfExists('e_answers');
    }
}
