<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToEClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('e_classes', function (Blueprint $table) {
          $table->unsignedInteger('e_groups_id')->change();
          $table->foreign('e_groups_id')->references('id')->on('e_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('e_classes', function (Blueprint $table) {
          $table->dropForeign('e_classes_e_groups_id_foreign');
        });
    }
}
