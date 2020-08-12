<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Article;
use App\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(Article::class, 2)->create()->each(function ($comment) {
        //Comment belong to User 1-n
        $user = User::find($comment->user_id);

        //Comment belong to Article 1-n
        $article = Article::find($comment->article_id);
      });
    }
}
