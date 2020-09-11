<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use App\Comment;

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
        $user = factory('App\User')->create();
        $comment = factory(Comment::class)->create(['user_id' => $user->id]);

        $this->assertEquals(1, $comment->user->count());
        $this->assertInstanceOf('App\User', $comment->user);
    }

    public function testUserFollowers()
    {

    }
}
