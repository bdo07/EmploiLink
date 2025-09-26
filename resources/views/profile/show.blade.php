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
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Profile Header -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-8">
                    <div class="flex items-start space-x-6">
                        <div class="w-24 h-24 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-3xl">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $user->name }}</h1>
                            @if($user->headline)
                                <p class="text-xl text-gray-600 dark:text-gray-400 mb-2">{{ $user->headline }}</p>
                            @endif
                            @if($user->location)
                                <p class="text-gray-500 mb-4">📍 {{ $user->location }}</p>
                            @endif
                            
                            <div class="flex items-center space-x-6 mb-4">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->posts->count() }}</div>
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

                            @auth
                                @if($user->id !== auth()->id())
                                    <div class="flex items-center space-x-3">
                                        @if(isset($isFollowing) && $isFollowing)
                                            <form action="{{ route('follow.destroy', $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                                                    Unfollow
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('follow.store', $user) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                                    Follow
                                                </button>
                                            </form>
                                        @endif
                                        <button class="border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                            Message
                                        </button>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>

                    @if($user->bio)
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold mb-2">About</h3>
                            <p class="text-gray-700 dark:text-gray-300">{{ $user->bio }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Stories Section -->
            @if(isset($stories) && $stories->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
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

            <!-- Posts Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Posts</h3>
                    
                    @forelse(isset($posts) ? $posts : collect() as $post)
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6 last:border-b-0 last:mb-0">
                            <!-- Post Header -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ substr($post->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-semibold">{{ $post->user->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                
                                @if($post->user_id === auth()->id())
                                <div class="relative">
                                    <button class="text-gray-400 hover:text-gray-600" onclick="toggleDropdown({{ $post->id }})">
                                        ⋯
                                    </button>
                                    <div id="dropdown-{{ $post->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg z-10">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">Edit</a>
                                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600">Delete</button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Post Content -->
                            <div class="mb-4">
                                <p class="text-gray-800 dark:text-gray-200">{{ $post->body }}</p>
                                
                                @if($post->media_path)
                                    <div class="mt-4">
                                        <img src="{{ Storage::url($post->media_path) }}" alt="Post media" class="w-full rounded-lg">
                                    </div>
                                @endif
                            </div>

                            <!-- Post Actions -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-6">
                                    <!-- Like Button -->
                                    <button onclick="toggleLike('post', {{ $post->id }})" class="flex items-center space-x-2 text-gray-500 hover:text-red-500 transition">
                                        <span>❤️</span>
                                        <span class="text-sm">{{ $post->likes->count() }}</span>
                                    </button>
                                    
                                    <!-- Comment Button -->
                                    <button onclick="toggleComments({{ $post->id }})" class="flex items-center space-x-2 text-gray-500 hover:text-blue-500 transition">
                                        <span>💬</span>
                                        <span class="text-sm">{{ $post->comments->count() }}</span>
                                    </button>
                                    
                                    <!-- Share Button -->
                                    <button class="flex items-center space-x-2 text-gray-500 hover:text-green-500 transition">
                                        <span>📤</span>
                                        <span class="text-sm">Share</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Comments Section -->
                            <div id="comments-{{ $post->id }}" class="hidden mt-4 border-t pt-4">
                                <!-- Add Comment Form -->
                                <form action="{{ route('comments.store') }}" method="POST" class="mb-4">
                                    @csrf
                                    <input type="hidden" name="commentable_type" value="App\Models\Post">
                                    <input type="hidden" name="commentable_id" value="{{ $post->id }}">
                                    <div class="flex space-x-3">
                                        <input type="text" name="body" placeholder="Write a comment..." class="flex-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Post</button>
                                    </div>
                                </form>
                                
                                <!-- Comments List -->
                                <div class="space-y-3">
                                    @foreach($post->comments as $comment)
                                        <div class="flex space-x-3">
                                            <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                                {{ substr($comment->user->name, 0, 1) }}
                                            </div>
                                            <div class="flex-1">
                                                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3">
                                                    <p class="font-medium text-sm">{{ $comment->user->name }}</p>
                                                    <p class="text-gray-800 dark:text-gray-200">{{ $comment->body }}</p>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1">{{ $comment->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">📝</div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No posts yet</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $user->name }} hasn't shared anything yet.</p>
                        </div>
                    @endforelse

                    <!-- Pagination -->
                    @if(isset($posts) && $posts->hasPages())
                        <div class="mt-6">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown(postId) {
            const dropdown = document.getElementById('dropdown-' + postId);
            dropdown.classList.toggle('hidden');
        }

        function toggleComments(postId) {
            const comments = document.getElementById('comments-' + postId);
            comments.classList.toggle('hidden');
        }

        function toggleLike(type, id) {
            // This would be implemented with AJAX calls to the like controller
            console.log('Toggle like for', type, id);
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.relative')) {
                document.querySelectorAll('[id^="dropdown-"]').forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
            }
        });
    </script>
</x-app-layout>