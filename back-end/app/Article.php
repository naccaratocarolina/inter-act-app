<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\User;
use App\Comment;

class Article extends Model
{
    //creates a variable that refers to the articles table
    //we will use to establish the permissions associated with roles
    protected $table = 'articles';


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    // public function comments()
    // {
    //     return $this->hasMany('App\User', 'commentId');
    // }

    //creat new Article
    public function createArticle(Request $request) {
      $this->title = $request->title;
      $this->description = $request->description;
      $this->image = $request->image;
      $this->category = $request->category;
      $this->date = $request->date;
      $this->user_id = $request->user_id;
      $this->save();
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
      if($request->date){
        $this->date = $request->date;
      }
      $this->save();
    }
}
