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
}
