<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Article;
use App\Comment;
use App\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Creating the moderator
        $moderator = Role::where('marker', 'moderator')->first();
        $admin = new User();
        $admin->name = 'Moderador';
        $admin->email = 'interact.ejcm@gmail.com';
        $admin->password = bcrypt('senha123');
        $admin->save();
        $admin->roles()->attach($moderator);

        //Creating the others registered users
        factory(User::class, 5)->create()->each(function ($user) {
          $articles = factory(Article::class,2)->make();
          $comments = factory(Comment::class,2)->make();
          $registeredUser = Role::where('marker', 'registered-user')->first();

          //User post Article 1-n
          $user->articles()->saveMany($articles);

          //User post Comment 1-n
          $user->comments()->saveMany($comments);

          //User like Article n-n
          $user->like()->attach($articles);

          //User have Role n-n
          $user->roles()->attach($registeredUser);

          //User follow n Users n-n
          $user->following()->attach(User::all()->random()->id);

          //User is followed by n Users n-n
          $user->followers()->attach(User::all()->random()->id);
        });
  }
}
