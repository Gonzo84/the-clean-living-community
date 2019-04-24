<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

class SurveryOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('survey_questions', function($table) {
            $table->string('type')->after('question');
            $table->string('options')->after('type');
        });

       Schema::table('survey_categories', function($table) {
           $table->dropColumn('type');
       });

        Artisan::call('db:seed', array('--class' => 'SurveySeeder'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('survey_questions', function($table) {
            $table->dropColumn('options');
            $table->dropColumn('type');
        });

        Schema::table('survey_categories', function($table) {
            $table->string('type')->after('title');
        });
    }
}
