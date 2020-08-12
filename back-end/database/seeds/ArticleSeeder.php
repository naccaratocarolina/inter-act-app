<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Article::class, 2)->create()->each(function ($article) {
          //User own Article 1-n
          $user = User::find($article->user_id);
        });
    }
}
