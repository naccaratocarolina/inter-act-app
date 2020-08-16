<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest as CommentRequest;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Users;
use App\Article;
use App\Comment;
use Auth;

class Comment extends Model
{
    protected $table = 'comments';

    /**
     * One to Many Relationship User & Comment
     * An User can post n Comments
     * A Comment can belong to 1 User
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * One to Many Relationship Article & Comment
     * An Article can have n Comments
     * A Comment can belong to 1 Article
     * @return mixed
     */
    public function article()
    {
        return $this->belongsTo('App\Article');
    }

    /**
     * Creates a new instance of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function postCommentOnArticle(CommentRequest $request, $article_id) {
      $user = Auth::user();
      $this->user_id = $user->id;
      $this->article_id = $article_id;

      $this->commentary = $request->commentary;
      $this->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function updateComment(Request $request) {
        $current = Carbon::now();
        if($request->commentary){
            $this->commentary = $request->commentary;
        }
        $this->save();
    }
}
