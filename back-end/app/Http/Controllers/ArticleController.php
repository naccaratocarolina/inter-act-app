<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ArticleRequest;
use App\Article;

class ArticleController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexArticle()
    {
        $articles = Article::orderBy('id', 'desc')->get();
        return response()->json(['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createArticle(ArticleRequest $request)
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
        $article = User::findOrFail($id);
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
    public function updateArticle(ArticleRequest $request, $id)
    {
        
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
        $article = Article::findOrFail($id);
        Article::destroy($id);
        return response()->json(['message' => 'Artigo deletado!', 'article' => $article]);
    }

    /**
   * Create a new controller instance.
   *
   * @return void
   */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
}
