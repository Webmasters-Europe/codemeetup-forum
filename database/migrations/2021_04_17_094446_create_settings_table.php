<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('button_text_color');
            $table->string('category_icons_color');
            $table->string('forum_name');
            $table->string('forum_image')->nullable();
            $table->unsignedInteger('number_categories_startpage');
            $table->unsignedInteger('number_last_entries_startpage');
            $table->unsignedInteger('number_posts');
            $table->text('email_contact_page')->nullable();
            $table->text('imprint_page');
            $table->string('copyright');
            $table->string('primary_color');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
}
