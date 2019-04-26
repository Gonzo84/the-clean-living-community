<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Search extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('users_location');

        Schema::table('users', function (Blueprint $table) {
            $table->string('latitude', 55)->after('survey_score')->nullable();
            $table->string('longitude', 55)->after('latitude')->nullable();
            $table->enum('type', ['friend', 'mentor'])->default('friend')->after('longitude')->nullable();
        });

        Schema::table('users_data', function (Blueprint $table) {
            $table->dropColumn('type');
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
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });

        Schema::create('users_location', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->string('latitude', 55);
            $table->string('longitude', 55);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
