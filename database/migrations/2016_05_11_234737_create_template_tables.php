<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->string('status', 25);
            $table->tinyInteger('include_collaborative_feedback')->unsigned()->default(1);
            $table->tinyInteger('required_num_reviews')->unsigned()->default(3);
            $table->integer('required_period_time')->unsigned()->default(86400);
            $table->integer('created_by_user_id')->unsigned()->nullable();
            $table->foreign('created_by_user_id')->references('id')->on('users');
            $table->integer('updated_by_user_id')->unsigned()->nullable();
            $table->foreign('updated_by_user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('template_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->integer('template_id')->unsigned();
            $table->foreign('template_id')->references('id')->on('templates');
            $table->tinyInteger('required');
            $table->tinyInteger('order');
            $table->integer('created_by_user_id')->unsigned();
            $table->foreign('created_by_user_id')->references('id')->on('users');
            $table->integer('updated_by_user_id')->unsigned();
            $table->foreign('updated_by_user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('template_section_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('template_section_id')->unsigned();
            $table->foreign('template_section_id')->references('id')->on('template_sections');
            $table->tinyInteger('required');
            $table->tinyInteger('order');
            $table->integer('created_by_user_id')->unsigned();
            $table->foreign('created_by_user_id')->references('id')->on('users');
            $table->integer('updated_by_user_id')->unsigned();
            $table->foreign('updated_by_user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('template_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('course_id', 25);
            $table->string('title');
            $table->string('course_url');
            $table->integer('template_id')->unsigned();
            $table->foreign('template_id')->references('id')->on('templates');
            $table->integer('created_by_user_id')->unsigned();
            $table->foreign('created_by_user_id')->references('id')->on('users');
            $table->integer('updated_by_user_id')->unsigned();
            $table->foreign('updated_by_user_id')->references('id')->on('users');
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
        Schema::drop('templates');
        Schema::drop('template_sections');
        Schema::drop('template_section_fields');
        Schema::drop('template_courses');
    }
}
