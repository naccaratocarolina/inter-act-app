<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowersFollowingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followers_following', function (Blueprint $table) {
            $table->primary(['follower_id', 'following_id']); //composite key
            $table->unsignedBigInteger('follower_id');
            $table->unsignedBigInteger('following_id');
        });

        Schema::table('followers_following', function (Blueprint $table) {
            $table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('following_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('followers_following');
    }
}
