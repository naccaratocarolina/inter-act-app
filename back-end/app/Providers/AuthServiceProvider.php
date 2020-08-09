<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use Article;
//use Comment;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
      //policy register
        'App\Article' => 'App\Policies\ArticlePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
         * Define the moderator gate
         * A moderator can do everything a registered user can,
         * plus delete and update all articles and comments
         * @return bool
         */

        Gate::define('isModerator', function ($user) {
            //if the given user's marker is equal to moderator
            if($user->roles->first()->marker == 'moderator') {
              return true; //rreturn true
            }
              return false; //otherwise, false
        });

        /**
         * Define the registered user gate
         * A registered user can see all articles and comments,
         * plus create, update and destroy them
         * A registered user can only delete and update their own articles and comments
         * @return bool
         */
        Gate::define('isRegisteredUser', function ($user) {
            //if the given user's marker is equal to registered-user
            if($user->roles->first()->marker == 'registered-user') {
              return true; //return true
            }
              return false; //otherwise, false
        });
    }
}
