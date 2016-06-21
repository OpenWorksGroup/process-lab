<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFrameworkIdTemplateRubric extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('template_rubrics', function (Blueprint $table) {
            $table->integer('competency_framework_id')->unsigned();
            $table->foreign('competency_framework_id')->references('id')->on('competency_frameworks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('template_rubrics', function (Blueprint $table) {
            $table->dropColumn('framework_id');
        });
    }
}
