<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

class UpdateUserSurvey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table)
        {
            $table->dropColumn('status');
        });

        Schema::table('users', function($table)
        {
            $table->integer('age')->nullable()->change();
            $table->boolean('married')->nullable()->change();
            $table->boolean('children')->nullable()->change();
            $table->boolean('pet')->nullable()->change();
            $table->string('education')->nullable()->change();
            $table->string('religion')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->string('sex_orientation')->nullable()->change();
            $table->integer('last_relapse')->nullable()->change();
            $table->boolean('smoker')->nullable()->change();
            $table->boolean('support_groups')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->integer('zip_code')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->enum('status', ['pending', 'regular', 'deleted'])->default('regular')->after('password');
        });

        Artisan::call('passport:install');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->integer('age')->change();
            $table->boolean('married')->change();
            $table->boolean('children')->change();
            $table->boolean('pet')->change();
            $table->string('education')->change();
            $table->string('religion')->change();
            $table->string('gender')->change();
            $table->string('sex_orientation')->change();
            $table->integer('last_relapse')->change();
            $table->boolean('smoker')->change();
            $table->boolean('support_groups')->change();
            $table->string('city')->change();
            $table->integer('zip_code')->change();
            $table->string('state')->change();
        });
    }
}
