<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $user->name }}'s Profile
            </h2>
            <a href="{{ route('feed') }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Feed
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column - Profile Info -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <!-- Profile Header -->
                            <div class="text-center mb-6">
                                <div class="w-24 h-24 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-3xl font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                                @if($user->headline)
                                    <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $user->headline }}</p>
                                @endif
                                @if($user->location)
                                    <p class="text-gray-500 dark:text-gray-500 text-sm mt-1">
                                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $user->location }}
                                    </p>
                                @endif
                            </div>

                            <!-- Stats -->
                            <div class="grid grid-cols-3 gap-4 mb-6">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $posts->total() }}</div>
                                    <div class="text-sm text-gray-500">Posts</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->followers->count() }}</div>
                                    <div class="text-sm text-gray-500">Followers</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->following->count() }}</div>
                                    <div class="text-sm text-gray-500">Following</div>
                                </div>
                            </div>

                            <!-- Bio -->
                            @if($user->bio)
                                <div class="mb-6">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">About</h4>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $user->bio }}</p>
                                </div>
                            @endif

                            <!-- Company -->
                            @if($user->company)
                                <div class="mb-6">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Company</h4>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $user->company }}</p>
                                </div>
                            @endif

                            <!-- Website -->
                            @if($user->website_url)
                                <div class="mb-6">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Website</h4>
                                    <a href="{{ $user->website_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">
                                        {{ $user->website_url }}
                                    </a>
                                </div>
                            @endif

                            <!-- Follow Button -->
                            @auth
                                @if($user->id !== auth()->id())
                                    <div class="flex items-center space-x-3">
                                        @if($isFollowing)
                                            <form action="{{ route('follow.destroy', $user) }}" method="POST" class="flex-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                                                    Unfollow
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('follow.store', $user) }}" method="POST" class="flex-1">
                                                @csrf
                                                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                                    Follow
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Stories Section -->
                    @if($stories->count() > 0)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Stories</h3>
                            <div class="flex space-x-4 overflow-x-auto">
                                @foreach($stories as $story)
                                    <div class="flex-shrink-0 w-20 text-center">
                                        <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full mx-auto mb-2 flex items-center justify-center text-white font-bold">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <p class="text-xs text-gray-500">{{ $story->created_at->diffForHumans() }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column - Posts -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-6">Posts</h3>
                            
                            @forelse($posts as $post)
                                <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6 last:border-b-0 last:mb-0">
                                    <!-- Post Header -->
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ $user->name }}</h4>
                                                <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                {{ ucfirst($post->visibility) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Post Content -->
                                    <div class="mb-4">
                                        <p class="text-gray-900 dark:text-white">{{ $post->body }}</p>
                                        
                                        @if($post->media_path)
                                            <div class="mt-4">
                                                @if(str_contains($post->media_path, '.mp4'))
                                                    <video class="w-full rounded-lg" controls>
                                                        <source src="{{ asset('storage/' . $post->media_path) }}" type="video/mp4">
                                                    </video>
                                                @else
                                                    <img src="{{ asset('storage/' . $post->media_path) }}" alt="Post media" class="w-full rounded-lg">
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Post Actions -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-6">
                                            <!-- Like Button -->
                                            <form action="{{ route('likes.store') }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="type" value="post">
                                                <input type="hidden" name="id" value="{{ $post->id }}">
                                                <button type="submit" class="flex items-center space-x-2 text-gray-500 hover:text-red-500 transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                    </svg>
                                                    <span>{{ $post->likes->count() }}</span>
                                                </button>
                                            </form>

                                            <!-- Comment Button -->
                                            <button class="flex items-center space-x-2 text-gray-500 hover:text-blue-500 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                </svg>
                                                <span>{{ $post->comments->count() }}</span>
                                            </button>
                                        </div>

                                        <!-- Post Actions Menu -->
                                        @auth
                                            @if($post->user_id === auth()->id())
                                                <div class="flex items-center space-x-2">
                                                    <a href="#" class="text-gray-500 hover:text-blue-500 transition">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-gray-500 hover:text-red-500 transition">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        @endauth
                                    </div>

                                    <!-- Comments Section -->
                                    @if($post->comments->count() > 0)
                                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                            <h5 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Comments</h5>
                                            @foreach($post->comments->take(3) as $comment)
                                                <div class="flex items-start space-x-3 mb-3">
                                                    <div class="w-6 h-6 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                                        {{ substr($comment->user->name, 0, 1) }}
                                                    </div>
                                                    <div class="flex-1">
                                                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3">
                                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $comment->user->name }}</p>
                                                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $comment->body }}</p>
                                                        </div>
                                                        <p class="text-xs text-gray-500 mt-1">{{ $comment->created_at->diffForHumans() }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @if($post->comments->count() > 3)
                                                <p class="text-sm text-blue-600 hover:text-blue-800 cursor-pointer">View all {{ $post->comments->count() }} comments</p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <div class="text-6xl mb-4">📝</div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No posts yet</h3>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $user->name }} hasn't shared anything yet.</p>
                                </div>
                            @endforelse

                            <!-- Pagination -->
                            @if($posts->hasPages())
                                <div class="mt-6">
                                    {{ $posts->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
