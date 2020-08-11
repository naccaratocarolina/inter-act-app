<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles_users', function (Blueprint $table) {
            $table->primary(['article_id', 'user_id']); //composite key
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('user_id');
        });

        Schema::table('articles_users', function (Blueprint $table) {
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
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
        Schema::dropIfExists('articles_users');
    }
}
