<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'max:3000'],
            'media' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,mp4', 'max:20480'],
            'visibility' => ['required', 'in:public,connections'],
        ]);

        $mediaPath = null;
        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('posts', 'public');
        }

        $post = $request->user()->posts()->create([
            'body' => $data['body'],
            'media_path' => $mediaPath,
            'visibility' => $data['visibility'],
        ]);

        return redirect()->route('feed')->with('status', 'Post published successfully!');
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $data = $request->validate([
            'body' => ['required', 'string', 'max:3000'],
            'visibility' => ['required', 'in:public,connections'],
        ]);

        $post->update($data);

        return back()->with('status', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        
        if ($post->media_path) {
            Storage::disk('public')->delete($post->media_path);
        }
        
        $post->delete();
        return back()->with('status', 'Post deleted successfully!');
    }
}
