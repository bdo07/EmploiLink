<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Story;
use App\Models\User;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'likes', 'comments.user'])
            ->latest()
            ->paginate(10);

        $stories = Story::active()
            ->with(['user', 'views'])
            ->latest()
            ->get()
            ->groupBy('user_id');

        return view('feed.index', compact('posts', 'stories'));
    }

    public function profile(User $user)
    {
        $posts = $user->posts()
            ->with(['likes', 'comments.user'])
            ->latest()
            ->paginate(10);

        $stories = $user->stories()
            ->active()
            ->with('views')
            ->latest()
            ->get();

        $isFollowing = auth()->check() && auth()->user()->following()->where('followed_id', $user->id)->exists();

        return view('profile.social', compact('user', 'posts', 'stories', 'isFollowing'));
    }
}