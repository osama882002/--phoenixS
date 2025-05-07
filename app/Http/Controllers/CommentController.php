<?php

// app/Http/Controllers/CommentController.php
namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use AuthorizesRequests;
    // public function reply(Request $request, Comment $comment)
    // {
    //     $request->validate(['body' => 'required|string']);

    //     $reply = new Comment([
    //         'user_id'   => Auth::id(),
    //         'post_id'   => $comment->post_id,
    //         'parent_id' => $comment->id,
    //         'body'      => $request->body,
    //     ]);

    //     $reply->save();

    //     return response()->json([
    //         'body' => $reply->body,
    //         'user_name' => auth::user()->name,
    //     ]);
    // }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $postId = $comment->post_id;
        $comment->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'تم حذف التعليق بنجاح',
            'remaining_comments' => Comment::where('post_id', $postId)->count(),

        ]);
}
}