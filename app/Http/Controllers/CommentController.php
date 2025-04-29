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
    public function reply(Request $request, Comment $comment)
    {
        $request->validate(['body' => 'required|string']);

        $reply = new Comment([
            'user_id'   => Auth::id(),
            'post_id'   => $comment->post_id,
            'parent_id' => $comment->id,
            'body'      => $request->body,
        ]);

        $reply->save();

        return response()->json([
            'body' => $reply->body,
            'user_name' => auth::user()->name,
        ]);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();
        return back()->with('success', 'تم حذف التعليق بنجاح.');
    }
}
