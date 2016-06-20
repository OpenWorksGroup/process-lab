<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTemplateSections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('template_sections', function($t) {
            $t->dropColumn('required');
            $t->unique(array('section_title', 'template_id'));
        });

        DB::statement('ALTER TABLE `template_sections` MODIFY `description` TEXT NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
