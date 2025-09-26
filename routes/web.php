<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{FeedController, PostController, StoryController, CommentController, LikeController, FollowController, JobOfferController};

// Public routes
Route::get('/', function () {
    $jobs = \App\Models\JobOffer::active()
        ->with('user')
        ->latest()
        ->paginate(12);
    return view('home', compact('jobs'));
})->name('home');
Route::get('/feed', [FeedController::class, 'index'])->name('feed');
Route::get('/jobs', [JobOfferController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{jobOffer}', [JobOfferController::class, 'show'])->name('jobs.show');
Route::get('/u/{user}', [FeedController::class, 'profile'])->name('profile.show');
Route::get('/profile/{user}', [FeedController::class, 'profile'])->name('user.profile');

// Authenticated routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('feed');
    })->name('dashboard');
    
    // Posts
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    
    // Stories
    Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
Route::get('/stories/all', function () {
    $stories = \App\Models\Story::active()
        ->with('user')
        ->latest()
        ->get()
        ->groupBy('user_id');
    return view('stories.all', compact('stories'));
})->name('stories.all');

Route::get('/stories/user/{user}', function (\App\Models\User $user) {
    $stories = $user->stories()
        ->active()
        ->with('views')
        ->latest()
        ->get();
    return view('stories.user', compact('user', 'stories'));
})->name('stories.user');
    Route::get('/stories/create', function () {
        return view('stories.create');
    })->name('stories.create');
    Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');
    Route::post('/stories/{story}/view', [StoryController::class, 'view'])->name('stories.view');
    Route::post('/stories/{story}/mark-viewed', function (\App\Models\Story $story) {
        if (auth()->check()) {
            $story->views()->firstOrCreate(['viewer_id' => auth()->id()]);
        }
        return response()->json(['success' => true]);
    })->name('stories.mark-viewed');
    Route::delete('/stories/{story}', [StoryController::class, 'destroy'])->name('stories.destroy');
    
    // Comments
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    
    // Likes
    Route::post('/likes', [LikeController::class, 'store'])->name('likes.store');
    Route::delete('/likes', [LikeController::class, 'destroy'])->name('likes.destroy');
    
    // Follows
    Route::post('/follow/{user}', [FollowController::class, 'store'])->name('follow.store');
    Route::delete('/follow/{user}', [FollowController::class, 'destroy'])->name('follow.destroy');
    
    // Jobs
    Route::post('/jobs', [JobOfferController::class, 'store'])->name('jobs.store');
    Route::put('/jobs/{jobOffer}', [JobOfferController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{jobOffer}', [JobOfferController::class, 'destroy'])->name('jobs.destroy');
});

require __DIR__ . '/admin.php';
