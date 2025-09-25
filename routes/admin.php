<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Users management
        Route::get('/users', [\App\Http\Controllers\Admin\UsersController::class, 'index'])->name('users.index');
        Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UsersController::class, 'destroy'])->name('users.destroy');
        
        // Posts management
        Route::get('/posts', [\App\Http\Controllers\Admin\PostsController::class, 'index'])->name('posts.index');
        Route::delete('/posts/{post}', [\App\Http\Controllers\Admin\PostsController::class, 'destroy'])->name('posts.destroy');
        
        // Stories management
        Route::get('/stories', [\App\Http\Controllers\Admin\StoriesController::class, 'index'])->name('stories.index');
        Route::delete('/stories/{story}', [\App\Http\Controllers\Admin\StoriesController::class, 'destroy'])->name('stories.destroy');
        
        // Jobs management
        Route::get('/jobs', [\App\Http\Controllers\Admin\JobsController::class, 'index'])->name('jobs.index');
        Route::post('/jobs', [\App\Http\Controllers\Admin\JobsController::class, 'store'])->name('jobs.store');
        Route::delete('/jobs/{jobOffer}', [\App\Http\Controllers\Admin\JobsController::class, 'destroy'])->name('jobs.destroy');
    });
