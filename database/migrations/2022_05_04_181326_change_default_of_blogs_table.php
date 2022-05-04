<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDefaultOfBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('like_total')->default(0)->change();
            $table->string('dislike_total')->default(0)->change();
            $table->string('comment_total')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('like_total')->default(NULL)->change();
            $table->string('dislike_total')->default(NULL)->change();
            $table->string('comment_total')->default(NULL)->change();
        });
    }
}
