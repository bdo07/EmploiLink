<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\StoryView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::active()
            ->with(['user', 'views'])
            ->latest()
            ->get()
            ->groupBy('user_id');
            
        return view('stories.index', compact('stories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'media' => ['required', 'file', 'mimes:jpg,jpeg,png,mp4', 'max:20480'],
            'caption' => ['nullable', 'string', 'max:200'],
        ]);

        $path = $request->file('media')->store('stories', 'public');

        $story = $request->user()->stories()->create([
            'media_path' => $path,
            'caption' => $data['caption'] ?? null,
            'expires_at' => Carbon::now()->addHours(24),
        ]);

        return back()->with('status', 'Story added successfully!');
    }

    public function view(Story $story)
    {
        // Mark story as viewed by current user
        StoryView::firstOrCreate([
            'story_id' => $story->id,
            'viewer_id' => auth()->id(),
        ]);

        return response()->json(['viewed' => true]);
    }

    public function destroy(Story $story)
    {
        $this->authorize('delete', $story);
        
        if ($story->media_path) {
            Storage::disk('public')->delete($story->media_path);
        }
        
        $story->delete();
        return back()->with('status', 'Story deleted successfully!');
    }
}
