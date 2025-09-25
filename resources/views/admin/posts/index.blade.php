<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manage Posts') }}
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
                            <h3 class="text-lg font-semibold">All Posts ({{ $posts->total() }})</h3>
                            <div class="flex items-center space-x-4">
                                <input type="text" placeholder="Search posts..." class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <select class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                    <option value="">All Posts</option>
                                    <option value="public">Public</option>
                                    <option value="connections">Connections Only</option>
                                    <option value="recent">Recent</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Posts List -->
                    <div class="space-y-6">
                        @forelse($posts as $post)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:shadow-md transition">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <!-- Post Header -->
                                        <div class="flex items-center space-x-3 mb-4">
                                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                                {{ substr($post->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <h4 class="font-semibold">{{ $post->user->name }}</h4>
                                                <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $post->visibility === 'public' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' }}">
                                                    {{ ucfirst($post->visibility) }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Post Content -->
                                        <div class="mb-4">
                                            <p class="text-gray-800 dark:text-gray-200 mb-3">{{ $post->body }}</p>
                                            
                                            @if($post->media_path)
                                                <div class="mb-3">
                                                    <img src="{{ Storage::url($post->media_path) }}" alt="Post media" class="w-full max-w-md rounded-lg">
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Post Stats -->
                                        <div class="flex items-center space-x-6 text-sm text-gray-500">
                                            <span class="flex items-center space-x-1">
                                                <span>❤️</span>
                                                <span>{{ $post->likes_count }} likes</span>
                                            </span>
                                            <span class="flex items-center space-x-1">
                                                <span>💬</span>
                                                <span>{{ $post->comments_count }} comments</span>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('profile.show', $post->user) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                            View User
                                        </a>
                                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <div class="text-6xl mb-4">📝</div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No posts found</h3>
                                <p class="text-gray-600 dark:text-gray-400">No posts have been created yet.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
