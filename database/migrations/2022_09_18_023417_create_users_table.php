<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('twitter_id');
            $table->string('twitter_screen_name');
            $table->string('name');
            $table->string('avatar');
            $table->string('access_token');
            $table->string('refresh_token');
            $table->dateTime('token_limit');
            $table->tinyInteger('online_status')->unsigned()->default(0);
            $table->tinyInteger('delete_flag')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
