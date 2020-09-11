<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use App\Role;
use App\User;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests whether the roles migration columns were created correctly
     *
     * @return void
     */
    public function testRolesDatabaseHasExpectedColumns()
    {
        $columns = ['id', 'name', 'marker'];
        $this->assertTrue(Schema::hasColumns('roles', $columns), 1);
    }

    /**
     * Test the relationship Roles BelongsToMany Users
     *
     * @return void
     */
    public function testRoleBelongsToManyUsers()
    {
        $role = factory(Role::class)->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $role->users);
    }
}
