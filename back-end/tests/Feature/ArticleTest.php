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
}
