<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToESettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('e_settings', function (Blueprint $table) {
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
        Schema::table('e_settings', function (Blueprint $table) {
          $table->dropForeign('e_settings_e_classes_id_foreign');
        });
    }
}
