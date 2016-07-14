<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentFieldContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_field_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('content_id')->unsigned();
            $table->foreign('content_id')->references('id')->on('contents');
            $table->integer('template_section_field_id')->unsigned();
            $table->foreign('template_section_field_id')->references('id')->on('template_section_fields');
            $table->string('type');
            $table->text('content')->nullable();
            $table->string('uri')->nullable();
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
        Schema::drop('content_field_contents');
    }
}
