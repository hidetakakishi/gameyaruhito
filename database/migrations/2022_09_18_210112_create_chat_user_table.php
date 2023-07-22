<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('chat_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->tinyInteger('delete_flag')->unsigned()->default(0);

            //外部キー制約
            // $table->foreign('chat_id')
            //     ->references('id')
            //     ->on('chats')
            //     ->onDelete('set null');
            // $table->foreign('user_id')
            //     ->references('id')
            //     ->on('users')
            //     ->onDelete('set null');

            $table->timestamps();

            $table->unique(['chat_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_user');
    }
}
