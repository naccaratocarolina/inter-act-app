<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $users = factory(User::class, 30)->create();

        foreach($users as $user) {
            $user->roles()->attach($role);
            $this->assertCount(1, $user->roles);
            $this->assertContainsOnlyInstancesOf(Role::class, $user->roles);
        }

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $role->users);
        $this->assertCount(30, $role->users);
        $this->assertContainsOnlyInstancesOf(User::class, $role->users);
    }
}
