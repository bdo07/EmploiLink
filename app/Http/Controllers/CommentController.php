<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'max:1000'],
            'commentable_type' => ['required', Rule::in(['App\\Models\\Post'])],
            'commentable_id' => ['required', 'integer'],
        ]);

        $commentable = $data['commentable_type']::findOrFail($data['commentable_id']);

        $comment = $request->user()->comments()->create([
            'body' => $data['body'],
            'commentable_type' => $data['commentable_type'],
            'commentable_id' => $data['commentable_id'],
        ]);

        return response()->json([
            'comment' => $comment->load('user'),
            'comments_count' => $commentable->comments()->count()
        ]);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        
        $comment->delete();
        
        return response()->json([
            'deleted' => true,
            'comments_count' => $comment->commentable->comments()->count()
        ]);
    }
}
