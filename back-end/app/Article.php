<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Users;
use App\Comments;

class Article extends Model
{
    protected $table = 'articles';
    
    //
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany('App\User', 'comment_id');
    }

    //creat new Article
    public function createArticle(ArticleRequest $request){
      $article = new Article;

      $this->title = $request->title;
      $this->description = $request->description;
      $this->image = $request->image;
      $this->category = $request->category;
      $this->id = $request->id;
      $this->save();
      return response()->json($article);
    }

    //update Article by user
    public function updateArticle(Request $request) {
      if($request->title){
        $this->title = $request->title;
      }
      if($request->description){
       $this->description = $request->description;
      }
      if($request->image){
        $this->image = $request->image;
      }
      if($request->category){
        $this->category = $request->category;
      }
      $this->save();
    }
}