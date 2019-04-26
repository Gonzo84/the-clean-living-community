<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SearchAndUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('age');
            $table->dropColumn('married');
            $table->dropColumn('children');
            $table->dropColumn('pet');
            $table->dropColumn('education');
            $table->dropColumn('religion');
            $table->dropColumn('gender');
            $table->dropColumn('sex_orientation');
            $table->dropColumn('last_relapse');
            $table->dropColumn('smoker');
            $table->dropColumn('support_groups');
            $table->dropColumn('city');
            $table->dropColumn('zip_code');
            $table->dropColumn('state');
            $table->integer('survey_score')->after('reset_password_token')->nullable();
        });

        Schema::create('users_data', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->nullable();
            $table->enum('type', ['friend', 'mentor'])->default('friend')->nullable();
            $table->integer('age')->nullable();
            $table->boolean('married')->nullable();
            $table->boolean('children')->nullable();
            $table->boolean('pet')->nullable();
            $table->string('education')->nullable();
            $table->string('religion')->nullable();
            $table->string('gender')->nullable();
            $table->string('sex_orientation')->nullable();
            $table->integer('last_relapse')->nullable();
            $table->boolean('smoker')->nullable();
            $table->boolean('support_groups')->nullable();
            $table->string('city')->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('state')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('users_location', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->string('latitude', 55);
            $table->string('longitude', 55);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('age')->after('reset_password_token');
            $table->boolean('married')->after('age');
            $table->boolean('children')->after('married');
            $table->boolean('pet')->after('children');
            $table->string('education')->after('pet');
            $table->string('religion')->after('education');
            $table->string('gender')->after('religion');
            $table->string('sex_orientation')->after('gender');
            $table->integer('last_relapse')->after('sex_orientation');
            $table->boolean('smoker')->after('last_relapse');
            $table->boolean('support_groups')->after('smoker');
            $table->string('city')->after('support_groups');
            $table->integer('zip_code')->after('city');
            $table->string('state')->after('zip_code');
            $table->dropColumn('survey_score');
        });

        Schema::dropIfExists('users_data');
        Schema::dropIfExists('users_location');
    }
}
