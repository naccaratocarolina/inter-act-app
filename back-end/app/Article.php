<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest as ArticleRequest;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;
use App\User;
use Auth;
use App\Input;

class Article extends Model
{
    /**
     * One to Many Relationship User & Article
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Many to Many Relationship User & Article
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function isLikedBy()
    {
        return $this->belongsToMany('App\User', 'likes');
    }

    /**
     * One to Many Relationship Article & Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Create a new Article
     *
     * @param Request $request
     */
    public function createArticle(Request $request)
    {
      //grab the user id that is making the request
      $user = Auth::user();
      $this->user_id = $user->id; //and saves it in the article table

      $this->title = $request->title;
      $this->subtitle = $request->subtitle;
      $this->text = $request->text;
      $this->category = $request->category;
      $this->likes_count = $this->isLikedBy->count();
      $this->image = $request->image;
      $this->save();
      date_default_timezone_set('America/Sao_Paulo');
      $now = Carbon::now();
      $this->date = $now->toFormattedDateString();
      $this->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     */
    public function updateArticle(Request $request)
    {
      if($request->title){
        $this->title = $request->title;
      }
      if($request->subtitle){
       $this->subtitle = $request->subtitle;
      }
      if($request->text){
       $this->text = $request->text;
      }
      if($request->category){
        $this->category = $request->category;
      }
      if($request->date){
        $this->date = $request->date;
      }
      if($request->image){
        $this->image = $request->image;
      }
      $this->save();
    }
}
