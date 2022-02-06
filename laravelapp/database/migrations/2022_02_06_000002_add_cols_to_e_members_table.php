<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToEMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('e_members', function (Blueprint $table) {
          $table->unsignedInteger('user_id')->change();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          $table->unsignedInteger('e_classes_id')->change();
          $table->foreign('e_classes_id')->references('id')->on('e_classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('e_members', function (Blueprint $table) {
          $table->dropForeign('e_members_user_id_foreign');
          $table->dropForeign('e_members_e_classes_id_foreign');
        });
    }
}
