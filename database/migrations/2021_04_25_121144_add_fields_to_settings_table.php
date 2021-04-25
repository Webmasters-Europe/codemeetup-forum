<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('forum_name'); 
            $table->string('forum_image'); 
            $table->unsignedInteger('number_categories_startpage'); 
            $table->unsignedInteger('number_last_entries_startpage'); 
            $table->string('contact_page');
            $table->string('imprint_page');
            $table->string('copyright_page');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
}
