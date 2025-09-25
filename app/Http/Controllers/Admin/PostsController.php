<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'likes', 'comments'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->paginate(20);
            
        return view('admin.posts.index', compact('posts'));
    }

    public function destroy(Post $post)
    {
        if ($post->media_path) {
            Storage::disk('public')->delete($post->media_path);
        }
        
        $post->delete();
        
        return back()->with('status', 'Post deleted successfully!');
    }
}
