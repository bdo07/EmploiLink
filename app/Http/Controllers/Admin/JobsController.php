<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    public function index()
    {
        $jobs = JobOffer::with('user')
            ->latest()
            ->paginate(20);
            
        return view('admin.jobs.index', compact('jobs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string'],
            'company' => ['required', 'string', 'max:200'],
            'location' => ['required', 'string', 'max:200'],
            'type' => ['required', 'in:full_time,part_time,contract,internship'],
            'salary_min' => ['nullable', 'integer', 'min:0'],
            'salary_max' => ['nullable', 'integer', 'gte:salary_min'],
            'is_active' => ['boolean'],
        ]);

        JobOffer::create($data + [
            'user_id' => null, // Admin posted job
            'is_active' => $data['is_active'] ?? true
        ]);

        return back()->with('status', 'Job posted successfully!');
    }

    public function destroy(JobOffer $jobOffer)
    {
        $jobOffer->delete();
        
        return back()->with('status', 'Job deleted successfully!');
    }
}
