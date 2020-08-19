<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ArticleRequest as ArticleRequest;

use App\User;
use App\Article;

class ArticleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAllArticles()
    {
        $articles = Article::orderBy('id', 'desc')->get();
        return response()->json(['articles' => $articles]);
    }

    /**
     * Display a listing of the resource that belongs to the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUserArticles($id)
    {
        $user = User::findOrFail($id);
        $articles = $user->articles; //grab the user's articles
        return response()->json(['articles' => $articles]);
    }

    /**
     * Display the article owner.
     *
     * @param  \App\Article  $article_id
     * @return \Illuminate\Http\Response
     */
    public function indexArticleOwner($article_id) {
      $article = Article::findOrFail($article_id);
      $article_owner = $article->user;
      return response()->json(['message' => 'Dono do artigo encontrado!', 'article_owner' => $article_owner]);
    }

    /**
     * Display a listing of the resource that belongs to the users that the user making the request follows.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFollowingArticles() {
      $user = Auth::user();
      //grab que users that $user is following
      $following_array = $user->following;
      $response = array();

      foreach($following_array as $following) {
        $articles = $following->articles;
        array_push($response, $articles);
      }
      return response()->json(['articles' => $response]);
    }

    /**
     * Creates a new instance of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createArticle(Request $request)
    {
      $article = new Article;
      $article->createArticle($request);
      return response()->json(['message' => 'Artigo criado!', 'article' => $article]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function showArticle($id)
    {
        $article = Article::findOrFail($id);
        return response()->json(['message' => 'Artigo encontrado!', 'article' => $article]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
     public function updateArticle(Request $request, $id)
     {
       $user = Auth::user();
       $article = Article::findOrFail($id);
       $article->updateArticle($request);
       return response()->json(['message' => 'Artigo editado!', 'article' => $article]);
     }

     /**
      * Remove the specified resource from storage.
      *
      * @param  \App\Article  $article
      * @return \Illuminate\Http\Response
      */
     public function destroyArticle($id)
     {
       $user = Auth::user();
       $article = Article::findOrFail($id);
       Article::destroy($id);
       return response()->json(['message' => 'Artigo deletado!', 'article' => $article]);
     }
}
