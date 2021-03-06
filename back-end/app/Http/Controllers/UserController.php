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
    public function construct()
    {
      $this->middleware('role');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexAllUsers()
    {
        $users = User::orderBy('id', 'desc')->get();
        return response()->json(['users' => $users]);
    }

    /**
     * Display a listing of the following users.
     *
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexFollowingUsers($user_id)
    {
      $user = User::findOrFail($user_id);
      $following = $user->following;
      return response()->json(['message' => 'Pessoas que vc segue encontradas!','following' => $following]);
    }

    /**
     * Display a listing of the followers users.
     *
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexFollowersUsers($user_id)
    {
      $user = User::findOrFail($user_id);
      $followers = $user->followers;
      return response()->json(['message' => 'Seguidores encontrados!','followers' => $followers]);
    }

    /**
     * Create a new User Aand assign a default Role
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showUser($id)
    {
      $user = User::findOrFail($id);
      return response()->json(['message' => 'User encontrado!', 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
     public function destroyUser($id)
     {
       $user = User::findOrFail($id);
       $user->roles()->detach();
       $user = User::destroy($id);
       return response()->json(['message' =>'User deletado!']);
      }

    /**
     * Function that can attach or detach the relationship of one user following another
     *
     * @param $following_id
     * @return \Illuminate\Http\JsonResponse
     */
     public function actionFollow($following_id)
     {
       $user = Auth::user();
       $following = User::findOrFail($following_id);

       if(!$user->following->contains($following->id)) {
         //attach the ids
         $user->following()->attach($following_id);
         $following->followers()->attach($user->id);
         $following = User::findOrFail($following_id);
          return response()->json(['message' => 'Agora voce segue ' . $following->name]);
       }
       else {
         //dettach the ids
         $user->following()->detach($following->id);
         $following->followers()->detach($user->id);
         $following = User::findOrFail($following_id);
         return response()->json(['message' => 'Voce parou de seguir ' . $following->name]);
       }
     }

    /**
     * Function that detach the relationship of one user following another
     *
     * @param $following_id
     * @return \Illuminate\Http\JsonResponse
     */
     public function removeFollow($following_id)
     {
       $user = Auth::user();
       $following = User::findOrFail($following_id);
       $user->following()->detach($following->id);
       $following->followers()->detach($user->id);
       $following = User::findOrFail($following_id);
       return response()->json(['message' => 'Voce parou de seguir ' . $following->name]);
     }

      /**
       * Function that check if an article was already followed
       *
       * @param  int  $id
       * @return bool
       */
     public function hasFollow($following_id)
     {
       $user = Auth::user();
       $following = User::findOrFail($following_id);

       $following_list = $user->following;

       foreach($following_list as $following_user)
       {
         if($following->id === $following_user->id)
         {
           return 1;
         }
       }
       return 0;
     }

    /**
     * Function that creates the relationship of one user liking an article
     *
     * @param $article_id
     * @return \Illuminate\Http\JsonResponse
     */
     public function actionLike($article_id) {
       $user = Auth::user();
       $article = Article::findOrFail($article_id);

       if(!$user->like->contains($article->id))
       {
         //attach the ids
         $user->like()->attach($article_id);
         //increments the likes count
         Article::where('id', $article_id)->increment('likes_count');
         $article = Article::findOrFail($article_id);
         return response()->json(['message' => 'Voce deu um like <3', 'likes_count'=> $article->likes_count] );
        }
       else {
         //attach the ids
         $user->like()->detach($article_id);
         //decrements the likes count
         Article::where('id', $article_id)->decrement('likes_count');
         $article = Article::findOrFail($article_id);
         return response()->json(['message' => 'Voce removeu o seu like :(', 'likes_count'=> $article->likes_count] );
       }
     }

    /**
     * Function that check if an article was already liked
     *
     * @param $article_id
     * @return int
     */
     public function hasLike($article_id)
     {
       $user = Auth::user();
       $article_like = Article::findOrFail($article_id);
       $articles = $user->like;

       foreach($articles as $article)
       {
         if($article_like->id === $article->id)
         {
           return 1;
         }
       }
       return 0;
     }

    /**
     * Function that check if an the authenticated user is a moderator
     *
     * @param $id
     * @return int
     */
     public function isModerator($id) {
       $user = User::findOrFail($id);
       if($user->roles->contains('marker', 'moderator'))
       {
         return 1;
       }
       return 0;
     }
}
