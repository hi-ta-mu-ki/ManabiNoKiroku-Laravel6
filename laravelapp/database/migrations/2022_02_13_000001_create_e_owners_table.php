<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_owners', function (Blueprint $table) {
          $table->Increments('id');
          $table->unsignedinteger('e_groups_id');
          $table->foreign('e_groups_id')->references('id')->on('e_groups')->onDelete('cascade');
          $table->unsignedinteger('user_id');
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('e_owners');
    }
}
