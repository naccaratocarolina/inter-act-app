<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\CommentRequest as CommentRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth as Auth;

class Comment extends Model
{
    protected $table = 'comments';

    /**
     * One to Many Relationship User & Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * One to Many Relationship Article & Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo('App\Article');
    }

    /**
     * Creates a new instance of the resource.
     *
     * @param CommentRequest $request
     * @param $article_id
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
     * @param CommentRequest $request
     */
    public function updateComment(CommentRequest $request) {
        $current = Carbon::now();
        if($request->commentary){
            $this->commentary = $request->commentary;
        }
        $this->save();
    }
}
