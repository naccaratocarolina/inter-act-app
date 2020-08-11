<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
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
     * A User can post n Comments
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

    //creat new comment by user
    public function createComment(Request $request) { //grab the user id that is making the request
      $user = Auth::user();
      $this->user_id = $user->id; //and saves it in the article table

        $current = Carbon::now();
        $this->commentary = $request->commentary;
        $this->save();
    }

    //update comment by user
    public function updateComment(Request $request) {
        $current = Carbon::now();
        if($request->commentary){
            $this->commentary = $request->commentary;
        }
        $this->save();
    }
}
