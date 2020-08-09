<?php

namespace App\Policies;

use App\Article;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAnyArticle(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function viewArticle(User $user, Article $article)
    {
        return $user->id === $article->user->id; //displays the user's articles
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function createArticle(User $user)
    {
        //check if the user has attached moderator or registered user roles
        if($user->roles->contains('marker', 'moderator')) {
          return true
        }
        else if($user->roles->contains('marker', 'registered-user')) {
          return true; //a registered user always can create an article
        }
        return false; //visitor
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function updateArticle(User $user, Article $article)
    {
        if($user->roles->contains('marker', 'moderator')) {
          return true
        }
        else if($user->roles->contains('marker', 'registered-user')) {
          if($user->id === $article->user->id) {
            return true; //only return true if the user owns the post
          }
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function deleteArticle(User $user, Article $article)
    {
      if($user->roles->contains('marker', 'moderator')) {
        return true
      }
      else if($user->roles->contains('marker', 'registered-user')) {
        if($user->id === $article->user->id) {
          return true; //only return true if the user owns the post
        }
      }
      return false;
    }
}