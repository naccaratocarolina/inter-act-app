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
    public function testUsersDatabaseHasExpectedColumns() {
        $columns = ['name', 'email', 'password', 'profile_picture', 'description', 'email_verified_at'];
        $this->assertTrue(Schema::hasColumns('users', $columns), 1);
    }
}
