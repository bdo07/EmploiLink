<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use Illuminate\Http\Request;

class JobOfferController extends Controller
{
    public function index()
    {
        $jobs = JobOffer::active()
            ->with('user')
            ->latest()
            ->paginate(20);
            
        return view('jobs.index', compact('jobs'));
    }

    public function show(JobOffer $jobOffer)
    {
        abort_unless($jobOffer->is_active, 404);
        
        $jobOffer->load('user');
        
        return view('jobs.show', compact('jobOffer'));
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

        $jobOffer = $request->user()->jobOffers()->create($data + [
            'is_active' => $data['is_active'] ?? true
        ]);

        return redirect()->route('jobs.index')->with('status', 'Job posted successfully!');
    }

    public function update(Request $request, JobOffer $jobOffer)
    {
        $this->authorize('update', $jobOffer);
        
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
        
        $jobOffer->update($data);
        
        return back()->with('status', 'Job updated successfully!');
    }

    public function destroy(JobOffer $jobOffer)
    {
        $this->authorize('delete', $jobOffer);
        
        $jobOffer->delete();
        
        return back()->with('status', 'Job deleted successfully!');
    }
}
