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
      public function actionFollow(Request $request, $id) {
        $user = Auth::user();
        $other_user = User::findOrFail($id);
        $action = $request->get('action');

        switch ($action) {
          case 'Follow':
            $user->following()->attach($id);
            $other_user->followers()->attach($user->id);
            return response()->json(['message' => 'Agora voce segue x ' . $other_user->name]);
            break;
          case 'Unfollow':
            $user->following()->detach($id);
            $other_user->followers()->detach($user->id);
            return response()->json(['message' => 'Voce parou de seguir x ' . $other_user->name]);
            break;
        }
      }

      /**
       * Function that check if an article was already followed
       *
       * @param  int  $id
       * @return bool
       */
      public function hasFollow($id) {
        $user = Auth::user();
        $other_user = User::findOrFail($id);

        $following_list = $user->following;

        foreach($following_list as $following) {
          if($other_user->id === $following->id) {
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
      public function actionLike(Request $request, $article_id) {
        $user = Auth::user();
        $article = Article::findOrFail($article_id);
        $action = $request->get('action');

        switch ($action) {
          case 'Like':
            Article::where('id', $article_id)->increment('likes_count');
            $user->like()->attach($article);
            $article->save();
            return response()->json(['Voce deu um like <3']);
            break;
          case 'Unlike':
            Article::where('id', $article_id)->decrement('likes_count');
            $user->like()->detach($article);
            $article->save();
            return response()->json(['Voce removeu o seu like :(']);
            break;
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
