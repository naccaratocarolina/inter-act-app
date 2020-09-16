<?php

namespace Tests\Feature;

use App\Http\Middleware\Authenticate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use App\User;
use App\Article;
use App\Comment;
use App\Role;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set Up method wil be executed before every test
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install', ['-vvv' => true]);
    }

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
     * Tests if the pivot table roles_users migration columns were created correctly
     *
     * @return void
     */
    public function testUserRolesDatabaseHasExpectedColumns()
    {
        $columns = ['role_id', 'user_id'];
        $this->assertTrue(Schema::hasColumns('roles_users', $columns));
    }

    /**
     * Tests if the pivot table following migration columns were created correctly
     *
     * @return void
     */
    public function testFollowingDatabaseHasExpectedColumns()
    {
        $columns = ['follower_id', 'follower_id'];
        $this->assertTrue(Schema::hasColumns('following', $columns));
    }

    /**
     * Tests if the pivot table followers migration columns were created correctly
     *
     * @return void
     */
    public function testFollowersDatabaseHasExpectedColumns()
    {
        $columns = ['follower_id', 'follower_id'];
        $this->assertTrue(Schema::hasColumns('followers', $columns));
    }

    /**
     * Tests if the pivot table likes migration columns were created correctly
     *
     * @return void
     */
    public function testLikesDatabaseHasExpectedColumns()
    {
        $columns = ['article_id', 'user_id'];
        $this->assertTrue(Schema::hasColumns('likes', $columns));
    }

    /**
     * Test the relationship User BelongsToMany Roles
     *
     * @return void
     */
    public function testUserBelongsToManyRoles()
    {
        $user = factory(User::class)->create();
        $roles = factory(Role::class, 30)->create();

        foreach($roles as $role) {
            $role->users()->attach($user);
            $this->assertCount(1, $role->users);
            $this->assertContainsOnlyInstancesOf(User::class, $role->users);
        }

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->roles);
        $this->assertCount(30, $user->roles);
        $this->assertContainsOnlyInstancesOf(Role::class, $user->roles);
    }

    /**
     * Test the relationship User HasMany Articles
     *
     * @return void
     */
    public function testUserHasManyArticles()
    {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->create(['user_id' => $user->id]);

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
        $articles = factory(Article::class, 30)->create();

        foreach($articles as $article) {
            $article->isLikedBy()->attach($user);
            $this->assertCount(1, $article->isLikedBy);
            $this->assertContainsOnlyInstancesOf(User::class, $article->isLikedBy);
        }

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->like);
        $this->assertCount(30, $user->like);
        $this->assertContainsOnlyInstancesOf(Article::class, $user->like);
    }

    /**
     * Test the relationship User Has Many Comments
     *
     * @return void
     */
    public function testUserHasManyComments()
    {
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create(['user_id' => $user->id]);

        $this->assertTrue($user->comments->contains($comment));
        $this->assertEquals(1, $user->comments->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->comments);
    }

    public function testUserFollowUsers()
    {
        $user = factory(User::class)->create();
        $followers = factory(User::class, 30)->create();

        foreach($followers as $follower) {
            $follower->following()->attach($user);
            $user->followers()->attach($follower);
            $this->assertCount(1, $follower->following);
            $this->assertContainsOnlyInstancesOf(User::class, $follower->following);
        }

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->followers);
        $this->assertCount(30, $user->followers);
        $this->assertContainsOnlyInstancesOf(User::class, $user->followers);
    }

    public function testUserFollowingUsers()
    {
        $user = factory(User::class)->create();
        $followings = factory(User::class, 30)->create();

        foreach($followings as $following) {
            $following->followers()->attach($user);
            $user->following()->attach($following);
            $this->assertCount(1, $following->followers);
            $this->assertContainsOnlyInstancesOf(User::class, $following->followers);
        }

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->following);
        $this->assertCount(30, $user->following);
        $this->assertContainsOnlyInstancesOf(User::class, $user->following);
    }

    /**
     * Test method POST
     *
     * @return void
     */
    public function testUserCreatedSuccessfully()
    {
        $userData = [
            "name" => "User",
            "email" => "user@user.com",
            "password" => "senha123"
        ];

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $this->json('POST', 'api/createUser', $userData, $headers)
            ->assertStatus(200)
            ->assertJson([
                "message" => "User criado!",
                "user" => [
                    "name" => "User",
                    "email" => "user@user.com"
                ]
            ])
        ;
        $this->assertCount(1, User::all());
    }

    /**
     * Test method GET
     *
     * @return void
     */
    public function testUserListedSuccessfully()
    {
        factory(User::class)->create([
            "name" => "User 1",
            "email" => "user1@email.com"
        ]);

        factory(User::class)->create([
            "name" => "User 2",
            "email" => "user2@email.com"
        ]);

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $this->json('GET', 'api/indexAllUsers', $headers)
            ->assertStatus(200)
            ->assertJson([
                "users" => [
                    [
                        "id" => 2,
                        "name" => "User 2",
                        "email" => "user2@email.com"
                    ],
                    [
                        "id" => 1,
                        "name" => "User 1",
                        "email" => "user1@email.com"
                    ]
                ]
            ])
        ;
    }

    /**
     * Test get user with ID
     *
     * @return void
     */
    public function testShowUser()
    {
        $user = factory(User::class)->create([
            "name" => "User",
            "email" => "user@user.com",
            "password" => "senha123"
        ]);

        $this->json('GET', 'api/showUser/'.$user->id, [])
            ->assertStatus(200)
            ->assertJson([
                "message" => "User encontrado!",
                "user" => [
                    "name" => "User",
                    "email" => "user@user.com"
                ]
            ])
        ;
    }

    /**
     * Test update user, method PUT
     *
     * @return void
     */
    public function testUpdateUser()
    {
        $user = factory(User::class)->create();

        $updatedData = [
            "name" => "Updated User",
            "email" => "updated_user@user.com",
            "password" => "123senha"
        ];

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $this->json('PUT', 'api/updateUser/'.$user->id, $updatedData, $headers)->assertStatus(200);
    }

    /**
     * Test destroy user, methor DELETE
     *
     * @return void
     */
    public function testDestroyUser()
    {
        $user = factory(User::class)->create();

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $this->json('DELETE', 'api/destroyUser/'.$user->id, [], [$headers])->assertStatus(200);
    }
}
