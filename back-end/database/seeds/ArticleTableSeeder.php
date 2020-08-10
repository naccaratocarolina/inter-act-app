<?php

use Illuminate\Database\Seeder;

use App\Article;
use App\Comment;
use App\User;

class ArticleTableSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //seeders executadas
        $this->call(Article_TableSeeder::class);
    }

    
}
