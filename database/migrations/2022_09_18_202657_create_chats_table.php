<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('detail');
            $table->string('image');
            $table->unsignedBigInteger('capacity');
            $table->tinyInteger('followers_only_flag')->unsigned()->default(0); // フォロワーのみ
            $table->tinyInteger('mutual_followers_only_flag')->unsigned()->default(0); // 相互フォロワーのみ
            $table->tinyInteger('delete_flag')->unsigned()->default(0);
            $table->dateTime('limit');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('unique_key');

            //外部キー制約
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

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
        Schema::dropIfExists('chats');
    }
}
