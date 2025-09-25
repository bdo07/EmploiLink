<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Job Opportunities') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                
                <!-- Filters Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Filters</h3>
                            
                            <!-- Job Type -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">Job Type</label>
                                <select class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                    <option value="">All Types</option>
                                    <option value="full_time">Full Time</option>
                                    <option value="part_time">Part Time</option>
                                    <option value="contract">Contract</option>
                                    <option value="internship">Internship</option>
                                </select>
                            </div>

                            <!-- Location -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">Location</label>
                                <input type="text" placeholder="Enter location" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                            </div>

                            <!-- Salary Range -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">Salary Range</label>
                                <div class="space-y-2">
                                    <input type="number" placeholder="Min Salary" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                    <input type="number" placeholder="Max Salary" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                </div>
                            </div>

                            <button class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                                Apply Filters
                            </button>
                        </div>
                    </div>

                    <!-- Post Job CTA -->
                    @auth
                    <div class="bg-gradient-to-r from-green-500 to-blue-500 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-white">
                            <h3 class="text-lg font-semibold mb-2">Hiring?</h3>
                            <p class="text-sm mb-4">Post your job and reach qualified candidates</p>
                            <a href="#post-job" class="block w-full bg-white text-green-600 text-center py-2 px-4 rounded-lg hover:bg-gray-100 transition">
                                Post a Job
                            </a>
                        </div>
                    </div>
                    @endauth
                </div>

                <!-- Jobs List -->
                <div class="lg:col-span-3">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $jobs->total() }} Job{{ $jobs->total() !== 1 ? 's' : '' }} Found
                        </h1>
                        <div class="flex items-center space-x-4">
                            <select class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="salary_high">Salary: High to Low</option>
                                <option value="salary_low">Salary: Low to High</option>
                            </select>
                        </div>
                    </div>

                    <!-- Jobs Grid -->
                    <div class="space-y-6">
                        @forelse($jobs as $job)
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                                <div class="p-6">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <!-- Job Header -->
                                            <div class="flex items-center space-x-3 mb-3">
                                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                                                    {{ substr($job->company, 0, 1) }}
                                                </div>
                                                <div>
                                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                        <a href="{{ route('jobs.show', $job) }}" class="hover:text-blue-600 transition">
                                                            {{ $job->title }}
                                                        </a>
                                                    </h3>
                                                    <p class="text-gray-600 dark:text-gray-400">{{ $job->company }}</p>
                                                </div>
                                            </div>

                                            <!-- Job Details -->
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-gray-500">📍</span>
                                                    <span class="text-gray-700 dark:text-gray-300">{{ $job->location }}</span>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-gray-500">💼</span>
                                                    <span class="text-gray-700 dark:text-gray-300 capitalize">{{ str_replace('_', ' ', $job->type) }}</span>
                                                </div>
                                                @if($job->salary_min || $job->salary_max)
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-gray-500">💰</span>
                                                    <span class="text-gray-700 dark:text-gray-300">
                                                        @if($job->salary_min && $job->salary_max)
                                                            ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}
                                                        @elseif($job->salary_min)
                                                            From ${{ number_format($job->salary_min) }}
                                                        @elseif($job->salary_max)
                                                            Up to ${{ number_format($job->salary_max) }}
                                                        @endif
                                                    </span>
                                                </div>
                                                @endif
                                            </div>

                                            <!-- Job Description Preview -->
                                            <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                                                {{ Str::limit($job->description, 200) }}
                                            </p>

                                            <!-- Job Footer -->
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                                    <span>Posted {{ $job->created_at->diffForHumans() }}</span>
                                                    @if($job->user)
                                                        <span>by {{ $job->user->name }}</span>
                                                    @endif
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('jobs.show', $job) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                                        View Details
                                                    </a>
                                                    <button class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                                                        Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-12 text-center">
                                    <div class="text-6xl mb-4">🔍</div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No jobs found</h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-6">Try adjusting your filters or check back later for new opportunities.</p>
                                    <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                                        Clear Filters
                                    </button>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $jobs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Post Job Modal -->
    @auth
    <div id="post-job-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Post a Job</h3>
                    <button onclick="closePostJobModal()" class="text-gray-400 hover:text-gray-600">
                        ✕
                    </button>
                </div>
                
                <form action="{{ route('jobs.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Title</label>
                            <input type="text" name="title" required class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Company</label>
                            <input type="text" name="company" required class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location</label>
                            <input type="text" name="location" required class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Type</label>
                            <select name="type" required class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="full_time">Full Time</option>
                                <option value="part_time">Part Time</option>
                                <option value="contract">Contract</option>
                                <option value="internship">Internship</option>
                            </select>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Min Salary</label>
                                <input type="number" name="salary_min" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max Salary</label>
                                <input type="number" name="salary_max" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Description</label>
                            <textarea name="description" rows="6" required class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end space-x-3 mt-6">
                        <button type="button" onclick="closePostJobModal()" class="px-4 py-2 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            Post Job
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endauth

    <script>
        function openPostJobModal() {
            document.getElementById('post-job-modal').classList.remove('hidden');
        }

        function closePostJobModal() {
            document.getElementById('post-job-modal').classList.add('hidden');
        }

        // Open modal when clicking "Post a Job" links
        document.addEventListener('DOMContentLoaded', function() {
            const postJobLinks = document.querySelectorAll('a[href="#post-job"]');
            postJobLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    openPostJobModal();
                });
            });
        });
    </script>
</x-app-layout>
