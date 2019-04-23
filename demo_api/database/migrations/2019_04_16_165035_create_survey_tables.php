<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('survey_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->unsigned();
            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');
            $table->string('title');
            $table->string('type');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('survey_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('survey_categories')->onDelete('cascade');
            $table->string('question');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('survey_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('answer');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('survey_questions')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_answers');
        Schema::dropIfExists('survey_questions');
        Schema::dropIfExists('survey_categories');
        Schema::dropIfExists('surveys');
    }
}
