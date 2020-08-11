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
     public function updateUser(Request $request, $id)
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
       * Function that creates the relationship of one user following another
       *
       * @param  int  $following_id
       * @return \Illuminate\Http\Response
       */
      public function follow($following_id) {
        $user = Auth::user();
        $following = User::findOrFail($following_id);
        $user->following()->attach($following_id);
        $user->save();
        return response()->json(['message' => 'Agora voce segue x ' . $following->name]);
      }

      /**
       * Function that detach the relationship of one user following another
       *
       * @param  int  $following_id
       * @return \Illuminate\Http\Response
       */
      public function unfollow($following_id) {
        $user = Auth::user();
        $following = User::findOrFail($following_id);
        $user->following()->detach($following_id);
        $user->save();
        return response()->json(['message' => 'Voce parou de seguir x ' . $following->name]);
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
      public function like($article_id) {
        $user = Auth::user();
        $article = Article::findOrFail($article_id);
        $user->like()->attach($article);
        $user->save();
        return response()->json(['message' => 'Artigo curtido! :)']);
      }

      /**
       * Function that detach the relationship of one user liking an article
       *
       * @param  int  $article_id
       * @return \Illuminate\Http\Response
       */
      public function dislike($article_id) {
        $user = Auth::user();
        $article = Article::findOrFail($article_id);
        $user->like()->detach($article);
        $user->save();
        return response()->json(['message' => 'Artigo descurtido!']);
      }
}
