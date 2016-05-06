<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
          $table->increments('id');
          $table->string('lti_user_id');
          $table->string('name');
          $table->string('email')->unique();
          $table->string('password', 60)->nullable();
          $table->string('profile_url')->nullable();
          $table->timestamp('last_login_at');
          $table->timestamps();
          $table->softDeletes();
          $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
