<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplateRubrics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_rubrics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('template_id')->unsigned();
            $table->foreign('template_id')->references('id')->on('templates');
            $table->integer('competency_framework_category_id')->unsigned();
            $table->foreign('competency_framework_category_id')->references('id')->on('competency_framework_categories');
            $table->text('description_1')->nullable();
            $table->text('description_2')->nullable();
            $table->text('description_3')->nullable();
            $table->text('description_4')->nullable();
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
        Schema::drop('template_rubrics');
    }
}
