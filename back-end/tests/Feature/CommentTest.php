<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use App\Article;
use App\Comment;
use App\User;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests if the comments migration columns were created correctly
     *
     * @return void
     */
    public function testCommentsDatabaseHasExpectedColumns() {
        $columns = ['id', 'commentary', 'user_id', 'article_id'];
        $this->assertTrue(Schema::hasColumns('comments', $columns), 1);
    }

    /**
     * Test the relationship Comment Belongs To User
     *
     * @return void
     */
    public function testCommentBelongsToUser()
    {
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create(['user_id' => $user->id]);

        $this->assertEquals(1, $comment->user->count());
        $this->assertInstanceOf('App\User', $comment->user);
    }

    /**
     * Test the relationship Comment Belongs To Article
     *
     * @return void
     */
    public function testCommentBelongsToArticle()
    {
        $article = factory(Article::class)->create();
        $comment = factory(Comment::class)->create(['article_id' => $article->id]);

        $this->assertEquals(1, $comment->article->count());
        $this->assertInstanceOf('App\Article', $comment->article);
    }
}
