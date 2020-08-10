<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CommentRequest;
use App\Comment;
use Carbon\Carbon;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexComment()
    {
        $comments = Comment::orderBy('id', 'desc')->get();
        return response()->json(['comments' => $comments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createComment(CommentRequest $request)
    {
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
        $comment = Comment::findOrFail($id);
        Comment::destroy($id);
        return response()->json(['message' => 'Comentário deletado!', 'comment' => $comment]);
    }
}
