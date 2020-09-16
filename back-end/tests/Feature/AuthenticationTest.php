<?php

namespace Tests\Feature;
use App\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\CreatesApplication;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    use CreatesApplication;

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
     * Test required fields for registration
     *
     * @return void
     */
    public function testRequiredFieldsForRegistration()
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $this->json('POST', 'api/register', $headers)
            ->assertStatus(422)
            ->assertJson([
                "name" => ["The name field is required."],
                "email" => ["The email field is required."],
                "password" => ["The password field is required."]
            ])
        ;
    }

    /**
     * Test a password without 6 chars at minimum
     *
     * @return void
     */
    public function testNonValidPassword()
    {
        $userData = [
            'name' => 'Carolina',
            'email' => 'carolina@carolina.com',
            'password' => 'senha',
        ];

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $this->json('POST', 'api/register', $userData, $headers)
            ->assertStatus(422)
            ->assertJson([
                "password" => ["The password must be at least 6 characters."]
            ]);
    }

    /**
     * Test non valid email
     *
     * @return void
     */
    public function testNonValidEmail()
    {
        $userData = [
            'name' => 'Carolina',
            'email' => 'carolina',
            'password' => 'senha123',
        ];

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $this->json('POST', 'api/register', $userData, $headers)
            ->assertStatus(422)
            ->assertJson([
                "email" => ["Insira um email válido"]
            ])
        ;
    }

    /**
     * Test successful registration
     *
     * @return void
     */
    public function testSuccessfulRegistration()
    {
        $userData = [
            'name' => 'Carolina',
            'email' => 'carolina@carolina.com',
            'password' => 'senha123',
        ];

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $this->json('POST', 'api/register', $userData, $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                "message",
                "data" => [
                    "user" => [
                        "name",
                        "email",
                        "description",
                        "updated_at",
                        "created_at",
                        "id",
                        "profile_picture"
                    ],
                    "token"
                ]
            ])
        ;
    }

    /**
     * Test successful login
     *
     * @return void
     */
    public function testSuccessfulLogin()
    {
        factory(User::class)->create([
            'email' => 'user@test.com',
            'password' => bcrypt('senha123')
        ]);

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $loginData = ['email' => 'user@test.com', 'password' => 'senha123'];

        $loggedUser = $this->json('POST', 'api/login', $loginData, $headers)
            ->assertStatus(200)
            ->assertJson(["message" => "Login concluido!"])
            ->assertJsonStructure([
                "message",
                "data" => [
                    "user" => [
                        "name",
                        "email",
                        "description",
                        "updated_at",
                        "created_at",
                        "id",
                        "profile_picture"
                    ],
                    "token"
                ]
            ])
        ;

        $this->assertNotNull($loggedUser->json('data.token'));
        $this->assertAuthenticated();
    }

    /**
     * Test getDetails
     *
     * @return void
     */
    public function testGetDetails()
    {
        $userData = [
            'name' => 'Carolina',
            'email' => 'carolina@carolina.com',
            'password' => 'senha123'
        ];

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $registeredUser = $this->json('POST', 'api/register', $userData, $headers)->assertStatus(200);
        $token = $registeredUser->json('data.token');
        $this->assertNotNull($token);
        $this->get('api/getDetails', ['Authorization' => 'Bearer '.$token])
            ->assertStatus(200)
            ->assertJson([
                "user" => [
                    'name' => 'Carolina',
                    'email' => 'carolina@carolina.com'
                ]
            ])
        ;
        $this->assertAuthenticated();
    }

    /**
     * Test successful logout
     *
     * @return void
     */
    public function testSuccessfulLogout()
    {
        factory(User::class)->create([
            'email' => 'user@test.com',
            'password' => bcrypt('senha123')
        ]);

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $loginData = ['email' => 'user@test.com', 'password' => 'senha123'];

        $registeredUser = $this->json('POST', 'api/login', $loginData, $headers)->assertStatus(200);
        $token = $registeredUser->json('data.token');
        $this->assertNotNull($token);
        $this->get('api/logout', ['Authorization' => 'Bearer '.$token])
            ->assertStatus(200)
            ->assertJson(["User deslogado!"])
        ;
    }
}
