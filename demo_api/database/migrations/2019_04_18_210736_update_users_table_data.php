<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTableData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
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
        });
    }
}
