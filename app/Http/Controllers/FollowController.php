<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function store(User $user)
    {
        abort_if(auth()->id() === $user->id, 400, 'Cannot follow yourself');
        
        auth()->user()->following()->syncWithoutDetaching([$user->id]);
        
        return response()->json([
            'following' => true,
            'followers_count' => $user->followers()->count()
        ]);
    }

    public function destroy(User $user)
    {
        auth()->user()->following()->detach($user->id);
        
        return response()->json([
            'following' => false,
            'followers_count' => $user->followers()->count()
        ]);
    }
}
