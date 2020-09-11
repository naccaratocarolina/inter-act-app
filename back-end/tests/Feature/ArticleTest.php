<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use App\Article;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests if the user migration articles were created correctly
     *
     * @return void
     */
    public function testArticlesDatabaseHasExpectedColumns() {
        $columns = ['id', 'title', 'subtitle', 'text', 'image', 'category', 'date', 'likes_count', 'is_liked', 'user_id'];
        $this->assertTrue(Schema::hasColumns('articles', $columns), 1);
    }

    /**
     * Test the relationship Article BelongsTO User
     *
     * @return void
     */
    public function testArticleBelongsToUser()
    {
        $user = factory('App\User')->create();
        $article = factory(Article::class)->create(['user_id' => $user->id]);

        $this->assertEquals(1, $article->user->count());
        $this->assertInstanceOf('App\User', $article->user);
    }

    /**
     * Test the relationship Article is Liked By (belongsToMany) Users
     *
     * @return void
     */
    public function testArticleIsLikedByUsers()
    {
        $article = factory(Article::class)->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $article->isLikedBy);
    }
}
