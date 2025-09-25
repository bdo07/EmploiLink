<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Post, Story, JobOffer, Comment, Like, Follow};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_posts' => Post::count(),
            'total_stories' => Story::count(),
            'total_jobs' => JobOffer::count(),
            'total_comments' => Comment::count(),
            'total_likes' => Like::count(),
            'total_follows' => Follow::count(),
            'active_stories' => Story::active()->count(),
            'active_jobs' => JobOffer::active()->count(),
        ];

        // Recent activity
        $recentPosts = Post::with('user')->latest()->take(5)->get();
        $recentJobs = JobOffer::with('user')->latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        // Daily stats for the last 7 days
        $dailyStats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dailyStats[] = [
                'date' => $date,
                'users' => User::whereDate('created_at', $date)->count(),
                'posts' => Post::whereDate('created_at', $date)->count(),
                'jobs' => JobOffer::whereDate('created_at', $date)->count(),
            ];
        }

        return view('admin.dashboard', compact('stats', 'recentPosts', 'recentJobs', 'recentUsers', 'dailyStats'));
    }
}
