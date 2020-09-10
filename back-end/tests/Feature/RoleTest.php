<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use App\Role;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests whether the roles migration columns were created correctly
     *
     * @return void
     */
    public function testRolesDatabaseHasExpectedColumns() {
        $columns = ['id', 'name', 'marker'];
        $this->assertTrue(Schema::hasColumns('roles', $columns), 1);
    }
}
