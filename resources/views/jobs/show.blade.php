<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $jobOffer->title }}
            </h2>
            <a href="{{ route('jobs.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Jobs
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Main Job Content -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-8">
                            <!-- Job Header -->
                            <div class="flex items-start space-x-4 mb-6">
                                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold text-2xl">
                                    {{ substr($jobOffer->company, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                        {{ $jobOffer->title }}
                                    </h1>
                                    <p class="text-xl text-gray-600 dark:text-gray-400 mb-2">{{ $jobOffer->company }}</p>
                                    <div class="flex items-center space-x-4 text-gray-500">
                                        <span class="flex items-center">
                                            📍 {{ $jobOffer->location }}
                                        </span>
                                        <span class="flex items-center">
                                            💼 {{ ucfirst(str_replace('_', ' ', $jobOffer->type)) }}
                                        </span>
                                        @if($jobOffer->salary_min || $jobOffer->salary_max)
                                        <span class="flex items-center">
                                            💰 
                                            @if($jobOffer->salary_min && $jobOffer->salary_max)
                                                ${{ number_format($jobOffer->salary_min) }} - ${{ number_format($jobOffer->salary_max) }}
                                            @elseif($jobOffer->salary_min)
                                                From ${{ number_format($jobOffer->salary_min) }}
                                            @elseif($jobOffer->salary_max)
                                                Up to ${{ number_format($jobOffer->salary_max) }}
                                            @endif
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Job Actions -->
                            <div class="flex items-center space-x-4 mb-8">
                                <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                                    Apply Now
                                </button>
                                <button class="border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 px-6 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    Save Job
                                </button>
                                <button class="border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 px-6 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    Share
                                </button>
                            </div>

                            <!-- Job Description -->
                            <div class="prose dark:prose-invert max-w-none">
                                <h2 class="text-2xl font-semibold mb-4">Job Description</h2>
                                <div class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">
                                    {{ $jobOffer->description }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Similar Jobs -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-4">Similar Jobs</h3>
                            <div class="space-y-4">
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-blue-500 rounded-lg flex items-center justify-center text-white font-bold">
                                            T
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold">Senior Frontend Developer</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">TechStart Inc.</p>
                                        </div>
                                        <span class="text-sm text-gray-500">Remote</span>
                                    </div>
                                </div>
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg flex items-center justify-center text-white font-bold">
                                            D
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold">UI/UX Designer</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Design Co.</p>
                                        </div>
                                        <span class="text-sm text-gray-500">New York</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Job Details -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Job Details</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Posted</span>
                                    <span class="text-gray-900 dark:text-white">{{ $jobOffer->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Job Type</span>
                                    <span class="text-gray-900 dark:text-white capitalize">{{ str_replace('_', ' ', $jobOffer->type) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Location</span>
                                    <span class="text-gray-900 dark:text-white">{{ $jobOffer->location }}</span>
                                </div>
                                @if($jobOffer->salary_min || $jobOffer->salary_max)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Salary</span>
                                    <span class="text-gray-900 dark:text-white">
                                        @if($jobOffer->salary_min && $jobOffer->salary_max)
                                            ${{ number_format($jobOffer->salary_min) }} - ${{ number_format($jobOffer->salary_max) }}
                                        @elseif($jobOffer->salary_min)
                                            From ${{ number_format($jobOffer->salary_min) }}
                                        @elseif($jobOffer->salary_max)
                                            Up to ${{ number_format($jobOffer->salary_max) }}
                                        @endif
                                    </span>
                                </div>
                                @endif
                                @if($jobOffer->user)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Posted by</span>
                                    <span class="text-gray-900 dark:text-white">{{ $jobOffer->user->name }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Company Info -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">About {{ $jobOffer->company }}</h3>
                            <div class="space-y-3">
                                <div class="flex items-center space-x-2">
                                    <span class="text-gray-500">🏢</span>
                                    <span class="text-gray-700 dark:text-gray-300">{{ $jobOffer->company }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-gray-500">📍</span>
                                    <span class="text-gray-700 dark:text-gray-300">{{ $jobOffer->location }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-gray-500">👥</span>
                                    <span class="text-gray-700 dark:text-gray-300">Company Size: Unknown</span>
                                </div>
                            </div>
                            <button class="w-full mt-4 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 py-2 px-4 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                View Company Profile
                            </button>
                        </div>
                    </div>

                    <!-- Quick Apply -->
                    @auth
                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-white">
                            <h3 class="text-lg font-semibold mb-2">Quick Apply</h3>
                            <p class="text-sm mb-4">Apply with your profile information</p>
                            <button class="w-full bg-white text-blue-600 py-2 px-4 rounded-lg hover:bg-gray-100 transition font-semibold">
                                Apply Now
                            </button>
                        </div>
                    </div>
                    @else
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center">
                            <h3 class="text-lg font-semibold mb-2">Want to Apply?</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">Sign in to apply for this job</p>
                            <a href="{{ route('login') }}" class="block w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                                Sign In
                            </a>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
