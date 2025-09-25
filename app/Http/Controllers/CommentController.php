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
            'commentable_type' => ['required', 'string'],
            'commentable_id' => ['required', 'integer'],
        ]);

        // Only allow whitelisted models to be commentable
        $allowed = [\App\Models\Post::class];
        abort_unless(in_array($data['commentable_type'], $allowed, true), 422);

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
