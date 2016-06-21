<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetencyFrameworks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competency_frameworks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('framework');
            $table->integer('created_by_user_id')->unsigned();
            $table->foreign('created_by_user_id')->references('id')->on('users');
            $table->integer('updated_by_user_id')->unsigned();
            $table->foreign('updated_by_user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('competency_framework_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category');
            $table->integer('framework_id')->unsigned();
            $table->foreign('framework_id')->references('id')->on('competency_frameworks');
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
        Schema::drop('competency_frameworks');
        Schema::drop('competency_framework_categories');
    }
}
