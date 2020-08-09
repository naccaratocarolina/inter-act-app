<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\User;

class Article extends Model
{
  /**
   * One to Many Relationship User & Article
   * A User can have n Articles
   * A Article can belong to 1 User
   * @return mixed
   */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

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
