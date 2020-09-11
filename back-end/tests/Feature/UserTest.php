<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests if the user migration columns were created correctly
     *
     * @return void
     */
    public function testUsersDatabaseHasExpectedColumns()
    {
        $columns = ['name', 'email', 'password', 'profile_picture', 'description', 'email_verified_at'];
        $this->assertTrue(Schema::hasColumns('users', $columns), 1);
    }

    /**
     * Test the relationship User BelongsToMany Roles
     *
     * @return void
     */
    public function testUserBelongsToManyRoles()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->roles);
    }

    /**
     * Test the relationship User HasMany Articles
     *
     * @return void
     */
    public function testUserHasManyArticles()
    {
        $user = factory(User::class)->create();
        $article = factory('App\Article')->create(['user_id' => $user->id]);

        $this->assertTrue($user->articles->contains($article));
        $this->assertEquals(1, $user->articles->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->articles);
    }

    /**
     * Test the relationship User like (belongsToMany) Articles
     *
     * @return void
     */
    public function testUserLikeArticle()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->like);
    }

    /**
     * Test the relationship User Has Many Comments
     *
     * @return void
     */
    public function testUserHasManyComments()
    {
        $user = factory(User::class)->create();
        $comment = factory('App\Comment')->create(['user_id' => $user->id]);

        $this->assertTrue($user->comments->contains($comment));
        $this->assertEquals(1, $user->comments->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->comments);
    }
}
