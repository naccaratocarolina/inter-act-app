<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Display a listing of the resource that belongs to the given user.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUserArticles()
    {
      $user = Auth::user();
      $articles = $user->articles; //grab the user's articles
      return response()->json(['articles' => $articles]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePhotoArticle(Request $request, $id)
    {
      $article = Article::find($id);
      $article->updatePhotoArticle($request);
      return response()->json(['message' => 'Foto editada!', 'article' => $article]);
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
      if($article->user_id == $user->id) { //if the user making the request own the article
        $article->updateArticle($request);
        return response()->json(['message' => 'Artigo editado!', 'article' => $article]);
      }
      return response()->json(['Voce nao pode editar esse artigo!']);
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
        if($article->user_id == $user->id) {
          Article::destroy($id);
          return response()->json(['message' => 'Artigo deletado!', 'article' => $article]);
        }
        return response()->json(['Voce nao pode deletar esse artigo!']);
    }

    /**
     * Counts the likes of an article.
     *
     * @param  int $id
     * @return object message, count
     */
    public function likesCounter($id) {
      $article = Article::findOrFail($id);
      $count = $article->isLikedBy->count();
      if($count == 1) {
        return response()->json(['message' => 'O seu artigo tem ' . $count . ' curtida', 'count' => $count]);
      }
      else {
        return response()->json(['message' => 'O seu artigo tem ' . $count . ' curtidas', 'count' => $count]);
      }
    }
}
