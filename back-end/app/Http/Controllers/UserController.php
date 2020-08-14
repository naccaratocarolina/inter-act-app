<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Requests\UserRequest as UserRequest;

use App\User;
use App\Role;
use App\Article;
use Auth;

class UserController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
    public function construct()
    {
      $this->middleware('role');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUser()
    {
        $users = User::orderBy('id', 'desc')->get();
        return response()->json(['users' => $users]);
    }

    /**
     * Create a new User
     * And assign a Role & Permission
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function createUser(UserRequest $request)
     {
       $user = new User;
       $user->createUser($request);
       return response()->json(['message' => 'User criado!', 'user' => $user]);
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showUser($id)
    {
      $user = User::findOrFail($id);
      return response()->json(['message' => 'User encontrado!', 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function updateUser(UserRequest $request, $id)
     {
       $user = User::find($id);
       $user->updateUser($request);
       return response()->json(['message' => 'User editado!', 'user' => $user]);
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroyUser($id)
     {
       $user = User::findOrFail($id);
       $user->roles()->detach();
       $user = User::destroy($id);
       return response()->json(['message' => 'User deletado!']);
      }

      /**
       * Function that can attach or detach the relationship of one user following another
       *
       * @param  int  $following_id
       * @return \Illuminate\Http\Response
       */
      public function actionFollow($following_id) {
        $user = Auth::user();
        $following = User::findOrFail($following_id);

        if(!$user->following->contains($following->id)) {
          $user->following()->attach($following_id);
          $following->followers()->attach($user->id);
          return response()->json(['message' => 'Agora voce segue x ' . $following->name]);
        }
        else {
          $user->following()->detach($following->id);
          $following->followers()->detach($user->id);
          return response()->json(['message' => 'Voce parou de seguir x ' . $following->name]);
        }
      }

      /**
       * Function that check if an article was already followed
       *
       * @param  int  $id
       * @return bool
       */
      public function hasFollow($following_id) {
        $user = Auth::user();
        $following = User::findOrFail($following_id);

        $following_list = $user->following;

        foreach($following_list as $following_user) {
          if($following->id === $following_user->id) {
            return 1;
          }
        }
        return 0;
      }

      /**
       * Counts how many followers the user making the request has
       *
       * @return object  message, count
       */
      public function followersCounter() {
        $user = Auth::user();
        $count = $user->following->count();
        if($count == 1) {
          return response()->json(['message' => 'Voce tem ' . $count . ' seguidor', 'count' => $count]);
        }
        else {
          return response()->json(['message' => 'Voce tem ' . $count . ' seguidores', 'count' => $count]);
        }
      }

      /**
       * Counts how many people the user making the request follows
       *
       * @return object  message, count
       */
      public function followingCounter() {
        $user = Auth::user();
        $count = $user->followers->count();
        if($count == 1) {
          return response()->json(['message' => 'Voce segue ' . $count . ' usuario', 'count' => $count]);
        }
        else {
          return response()->json(['message' => 'Voce segue ' . $count . ' usuarios', 'count' => $count]);
        }
      }

      /**
       * Function that creates the relationship of one user liking an article
       *
       * @param  int  $article_id
       * @return \Illuminate\Http\Response
       */
      public function actionLike($article_id) {
        $user = Auth::user();
        $article = Article::findOrFail($article_id);

        if(!$user->like->contains($article->id)) {
          $user->like()->attach($article_id);
          return response()->json(['Voce deu um like <3']);
        }
        else {
          $user->like()->detach($article_id);
          return response()->json(['Voce removeu o seu like :(']);
        }
      }

      /**
       * Function that check if an article was already liked
       *
       * @param  int  $article_id
       * @return bool
       */
      public function hasLike($article_id) {
        $user = Auth::user();
        $article_like = Article::findOrFail($article_id);
        $articles = $user->like;

        foreach($articles as $article) {
          if($article_like->id === $article->id) {
            return 1;
          }
        }
        return 0;
      }
}
