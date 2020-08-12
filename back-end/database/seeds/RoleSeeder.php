<?php

use Illuminate\Database\Seeder;

use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $moderator = new Role();
      $moderator->name = 'Moderador';
      $moderator->marker = 'moderator';
      $moderator->save();

      $registeredUser = new Role();
      $registeredUser->name = 'Usuário registrado';
      $registeredUser->marker = 'registered-user';
      $registeredUser->save();
    }
}
