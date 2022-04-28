<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();;
//            $table->foreign('category_id')->references('id')->on('areas');
            $table->unsignedBigInteger('area_id')->nullable();;
//            $table->foreign('area_id')->references('id')->on('areas');
            $table->unsignedBigInteger('country_id')->nullable();
//            $table->foreign('country_id')->references('id')->on('countries');
            $table->unsignedBigInteger('province_id')->nullable();
//            $table->foreign('province_id')->references('id')->on('provinces');
            $table->unsignedBigInteger('city_id')->nullable();
//            $table->foreign('city_id')->references('id')->on('cities');
            $table->unsignedBigInteger('district_id')->nullable();
//            $table->foreign('district_id')->references('id')->on('districts');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_subjects');
    }
}
