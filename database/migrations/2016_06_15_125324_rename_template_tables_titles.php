<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTemplateTablesTitles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('template_sections', function($t) {
            $t->renameColumn('title', 'section_title');
        });

        Schema::table('template_section_fields', function($t) {
            $t->renameColumn('title', 'field_title');
        });  

        Schema::table('template_courses', function($t) {
            $t->renameColumn('title', 'course_title');
        });  
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
