<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSettingsCompetencyFrameworksValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function ($table) {
            $table->string('competency_framework_description_1')->nullable();
            $table->string('competency_framework_description_2')->nullable();
            $table->string('competency_framework_description_3')->nullable();
            $table->string('competency_framework_description_4')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function ($table) {
            $table->dropColumn('competency_framework_description_1');
            $table->dropColumn('competency_framework_description_2');
            $table->dropColumn('competency_framework_description_3');
            $table->dropColumn('competency_framework_description_4');
        });
    }
}
