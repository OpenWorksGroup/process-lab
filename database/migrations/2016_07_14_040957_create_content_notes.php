<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('content_id')->unsigned();
            $table->foreign('content_id')->references('id')->on('contents');
            $table->text('note')->nullable();
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
        Schema::drop('content_notes');
    }
}
