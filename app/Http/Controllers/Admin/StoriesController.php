<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoriesController extends Controller
{
    public function index()
    {
        $stories = Story::with(['user', 'views'])
            ->withCount('views')
            ->latest()
            ->paginate(20);
            
        return view('admin.stories.index', compact('stories'));
    }

    public function destroy(Story $story)
    {
        if ($story->media_path) {
            Storage::disk('public')->delete($story->media_path);
        }
        
        $story->delete();
        
        return back()->with('status', 'Story deleted successfully!');
    }
}
