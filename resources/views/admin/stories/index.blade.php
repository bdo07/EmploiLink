<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manage Stories') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    <!-- Header -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold">All Stories ({{ $stories->total() }})</h3>
                            <div class="flex items-center space-x-4">
                                <input type="text" placeholder="Search stories..." class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <select class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                    <option value="">All Stories</option>
                                    <option value="active">Active</option>
                                    <option value="expired">Expired</option>
                                    <option value="recent">Recent</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Stories Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($stories as $story)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-md transition">
                                <!-- Story Media -->
                                <div class="aspect-video bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center">
                                    @if($story->media_path)
                                        <img src="{{ Storage::url($story->media_path) }}" alt="Story media" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-white text-4xl">📖</span>
                                    @endif
                                </div>
                                
                                <!-- Story Info -->
                                <div class="p-4">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                            {{ substr($story->user->name, 0, 1) }}
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-sm">{{ $story->user->name }}</h4>
                                            <p class="text-xs text-gray-500">{{ $story->created_at->diffForHumans() }}</p>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            @if($story->expires_at > now())
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                    Expired
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    @if($story->caption)
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ Str::limit($story->caption, 100) }}</p>
                                    @endif

                                    <!-- Story Stats -->
                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <span class="flex items-center space-x-1">
                                            <span>👁️</span>
                                            <span>{{ $story->views_count }} views</span>
                                        </span>
                                        <span>Expires {{ $story->expires_at->diffForHumans() }}</span>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center justify-end space-x-2 mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                        <a href="{{ route('profile.show', $story->user) }}" class="text-blue-600 hover:text-blue-800 text-xs">
                                            View User
                                        </a>
                                        <form action="{{ route('admin.stories.destroy', $story) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this story?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-xs">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <div class="text-6xl mb-4">📖</div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No stories found</h3>
                                <p class="text-gray-600 dark:text-gray-400">No stories have been created yet.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $stories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
