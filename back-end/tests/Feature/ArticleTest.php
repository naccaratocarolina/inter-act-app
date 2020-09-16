<?php

namespace Tests\Feature;

use App\Comment;
use App\User;
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
    public function testArticlesDatabaseHasExpectedColumns()
    {
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
        $user = factory(User::class)->create();
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
        $users = factory(User::class, 30)->create();

        foreach($users as $user) {
            $user->like()->attach($article);
            $this->assertCount(1, $user->like);
            $this->assertContainsOnlyInstancesOf(Article::class, $user->like);
        }

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $article->isLikedBy);
        $this->assertCount(30, $article->isLikedBy);
        $this->assertContainsOnlyInstancesOf(User::class, $article->isLikedBy);
    }

    /**
     * Test the relationship Article hasMany Comments
     *
     * @return void
     */
    public function testArticleHasManyComments()
    {
        $article = factory(Article::class)->create();
        $comment = factory(Comment::class)->create(['article_id' => $article->id]);

        $this->assertTrue($article->comments->contains($comment));
        $this->assertCount(1, $article->comments);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $article->comments);
    }
}
