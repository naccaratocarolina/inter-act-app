<?php

namespace App\Policies;

use App\Comment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAnyComment(User $user)
    {
        return false; //unregistered users cannot see any comments
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function viewComment(User $user, Comment $comment)
    {
        return $user->id === $comment->user->id; //displays the user's comments
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function createComment(User $user)
    {
        //check if the user has attached moderator or registered user roles
        if($user->roles->contains('marker', 'moderator')) {
          return true
        }
        else if($user->roles->contains('marker', 'registered-user')) {
          return true; //a registered user always can create an comment
        }
          return false; //visitor
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function updateComment(User $user, Comment $comment)
    {
        if($user->roles->contains('marker', 'moderator')) {
        return true
        }
        else if($user->roles->contains('marker', 'registered-user')) {
          if($user->id === $comment->user->id) {
            return true; //only return true if the user owns the post
          }
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function deleteComment(User $user, Comment $comment)
    {
        if($user->roles->contains('marker', 'moderator')) {
        return true
        }
        else if($user->roles->contains('marker', 'registered-user')) {
          if($user->id === $comment->user->id) {
            return true; //only return true if the user owns the post
          }
        }
        return false;
    }
}
