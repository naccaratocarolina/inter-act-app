<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CommentRequest;
use App\Comment;
use App\Article;
use Carbon\Carbon;
use Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAllComment()
    {
        $comments = Comment::orderBy('id', 'desc')->get();
        return response()->json(['comments' => $comments]);
    }

    /**
     * Display a listing of the resource that belongs to the given user.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUserComment()
    {
        $user = Auth::user();
        $comments = $user->comments; //grab the user's comments
        return response()->json(['comments' => $comments]);
    }

    /**
     * Display a listing of the resource that belongs to the given user.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexArticleComment()
    {
        $article = Auth::article();
        $comments = $article->comments; //grab the user's comments
        return response()->json(['comments' => $comments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createComment(CommentRequest $request, $article_id)
    {
        $article = Auth::article();
        $article = Article::findOrFail($article_id);
        $comment = new Comment;
        $comment->createComment($request);
        return response()->json(['message' => 'Comentário criado!', 'comment' => $comment]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function updateComment(CommentRequest $request, $id)
    {
        $user = Auth::user();
        $article = Auth::article();
        $comment = Comment::findOrFail($id);
        if($comment->user_id === $user->id){ //if the user making the request own the comment
            $comment->updateComment($request);
            return response()->json(['message' => 'Comentário editado!', 'comment' => $comment]);
        }
        return response()->json(['Voce não pode editar este comentário']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function showComment($id)
    {
        $comment = Comment::findOrFail($id);
        return response()->json(['message' => 'Comentário encontrado!', 'comment' => $comment]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroyComment($id)
    {
        $user = Auth::user();
        $article = Auth::article();
        $comment = Comment::findOrFail($id);
        if($comment->user_id === $user->id){
            Comment::destroy($id);
            return response()->json(['message' => 'Comentário deletado!', 'comment' => $comment]);
        }
        return response()->json(['message' => 'Comentário deletado!', 'comment' => $comment]);
        
    }
}
