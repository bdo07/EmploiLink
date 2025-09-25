<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', Rule::in(['post', 'comment'])],
            'id' => ['required', 'integer'],
        ]);

        $model = $data['type'] === 'post'
            ? \App\Models\Post::findOrFail($data['id'])
            : \App\Models\Comment::findOrFail($data['id']);

        $like = $model->likes()->firstOrCreate([
            'user_id' => $request->user()->id
        ]);

        return response()->json([
            'liked' => true,
            'likes_count' => $model->likes()->count()
        ]);
    }

    public function destroy(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', Rule::in(['post', 'comment'])],
            'id' => ['required', 'integer'],
        ]);

        $model = $data['type'] === 'post'
            ? \App\Models\Post::findOrFail($data['id'])
            : \App\Models\Comment::findOrFail($data['id']);

        $model->likes()->where('user_id', $request->user()->id)->delete();

        return response()->json([
            'liked' => false,
            'likes_count' => $model->likes()->count()
        ]);
    }
}
