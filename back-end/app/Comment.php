<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Users;
use App\Articles;
use App\Comment;

class Comment extends Model
{
    protected $table = 'comments';
    
    //
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function article()
    {
        return $this->belongsTo('App\User', 'article_id');
    }

    //creat new comment
    public function createComment(Request $request) {
        $comment = new Comment;
        $current = Carbon::now();
        $this->commentary = $request->commentary;
        $this->user_id = $request->user_id;
        $this->save();
        return response()->json($comment);
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
