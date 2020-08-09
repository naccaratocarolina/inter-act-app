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
        return $this->belongsTo('App\User', 'userId');
    }

    public function comments()
    {
        return $this->hasMany('App\User', 'commentId');
    }

    //creat new commentary
    public function creatCommentary(Request $request) {
        $comment = new Comment;
        $comment->text = $request->text;
        $comment->user_id = $request->user_id;
        $comment->article_id = $request->article_id;
        $comment->save();
        return response()->json($comment);
    }

    //update commentary by user
    public function userUpdateComment(Request $request, $id, $user_id) {
        $comment = Comment::findOrFail($id);
        $user = User::findOrFail($user_id);
        $comments = $user->comments;
        foreach($comments as $user_comment) {
          if($user_comment->id === $id) { //check if the comment with the $id has relation with the $user_id
            $user_comment->text = $request->text; //if yes, update text attribute
            $user_comment->save();
            return response()->json([$user_comment, 'Comentario postado!']);
          }
        }
        return response()->json(['Sem permissao para editar esse comentario!']);
      }
}
