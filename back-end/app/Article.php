<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use Auth;

class Article extends Model
{
  /**
   * One to Many Relationship User & Article
   * An User can have n Articles
   * A Article can belong to 1 User
   * @return mixed
   */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Many to Many Relationship User & Article
     * An User can like n Articles
     * A Article can be liked by n Users
     * @return mixed
     */
      public function isLikedBy()
      {
          return $this->belongsToMany('App\User', 'articles_users');
      }

    /**
     * One to Many Relationship Article & Comment
     * An Article can have n Comments
     * A Comment can belong to 1 Article
     * @return mixed
     */
     public function comments()
     {
         return $this->hasMany('App\Comment');
     }

    //creat new Article
    public function createArticle(Request $request) {
      //grab the user id that is making the request
      $user = Auth::user();
      $this->user_id = $user->id; //and saves it in the article table

      $this->title = $request->title;
      $this->subtitle = $request->subtitle;
      $this->text = $request->text;
      $this->image = $request->image;
      $this->category = $request->category;
      $this->date = $request->date;
      $this->save();
    }

    //update Article by user
    public function updateArticle(Request $request) {
      if($request->title){
        $this->title = $request->title;
      }
      if($request->subtitle){
       $this->subtitle = $request->subtitle;
      }
      if($request->text){
       $this->text = $request->text;
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
