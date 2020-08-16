<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest as CommentRequest;
use App\Comment;
use App\Article;
use Carbon\Carbon;
use App\User;
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
     * Display a listing of the resource that belongs to given user.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUserComment($user_id)
    {
        $user = User::findOrFail($user_id);
        $comments = $user->comments; //grab the user's comments
        return response()->json(['comments' => $comments]);
    }

    /**
     * Display a listing of the resource witch was assigned to the given article.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexArticleComment($article_id)
    {
        $article = Article::findOrFail($article_id);
        $comments = $article->comments;
        return response()->json(['comments' => $comments]);
    }

    /**
     * Display the article owner.
     *
     * @param  \App\Comment  $comment_id
     * @return \Illuminate\Http\Response
     */
    public function indexCommentOwner($id) {
      $comment = Comment::findOrFail($id);
      $comment_owner = $comment->user;
      return response()->json(['message' => 'Dono do comentario encontrado!', 'comment_owner' => $comment_owner]);
    }

    /**
     * Creates a new instance of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function postCommentOnArticle(CommentRequest $request, $article_id) {
      $comment = new Comment;
      $comment->postCommentOnArticle($request, $article_id);
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
        $comment = Comment::findOrFail($id);
        $comment->updateComment($request);
        return response()->json(['message' => 'Comentário editado!', 'comment' => $comment]);
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
        $comment = Comment::findOrFail($id);
        Comment::destroy($id);
        return response()->json(['message' => 'Comentário deletado!', 'comment' => $comment]);
    }
}
