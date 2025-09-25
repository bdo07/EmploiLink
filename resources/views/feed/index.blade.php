<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Feed') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                
                <!-- Left Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                            <div class="space-y-3">
                                <a href="#create-post" class="block w-full bg-blue-600 text-white text-center py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                                    Create Post
                                </a>
                                <a href="#create-story" class="block w-full bg-purple-600 text-white text-center py-2 px-4 rounded-lg hover:bg-purple-700 transition">
                                    Add Story
                                </a>
                                <a href="{{ route('jobs.store') }}" class="block w-full bg-green-600 text-white text-center py-2 px-4 rounded-lg hover:bg-green-700 transition">
                                    Post Job
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Stories -->
                    @if($stories->count() > 0)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Stories</h3>
                            <div class="space-y-3">
                                @foreach($stories->take(5) as $userStories)
                                    @php $story = $userStories->first() @endphp
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ substr($story->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium">{{ $story->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $userStories->count() }} stories</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Main Feed -->
                <div class="lg:col-span-2">
                    <!-- Create Post Form -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <textarea name="body" rows="3" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="What's on your mind?"></textarea>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <label class="flex items-center">
                                            <input type="file" name="media" class="hidden" id="media-upload">
                                            <span class="text-sm text-gray-600 dark:text-gray-400 cursor-pointer hover:text-gray-800 dark:hover:text-gray-200">
                                                📷 Photo/Video
                                            </span>
                                        </label>
                                        
                                        <select name="visibility" class="text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                            <option value="public">Public</option>
                                            <option value="connections">Connections Only</option>
                                        </select>
                                    </div>
                                    
                                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                        Post
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Posts Feed -->
                    <div class="space-y-6">
                        @forelse($posts as $post)
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6">
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
                                    <div class="flex items-center justify-between border-t pt-4">
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
                            </div>
                        @empty
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-center">
                                    <p class="text-gray-500 dark:text-gray-400">No posts yet. Be the first to share something!</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Trending Jobs -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Trending Jobs</h3>
                            <div class="space-y-3">
                                <div class="border-l-4 border-blue-500 pl-3">
                                    <p class="font-medium">Senior Developer</p>
                                    <p class="text-sm text-gray-500">Tech Corp</p>
                                    <p class="text-xs text-gray-400">Remote</p>
                                </div>
                                <div class="border-l-4 border-green-500 pl-3">
                                    <p class="font-medium">Marketing Manager</p>
                                    <p class="text-sm text-gray-500">StartupXYZ</p>
                                    <p class="text-xs text-gray-400">New York</p>
                                </div>
                            </div>
                            <a href="{{ route('jobs.index') }}" class="block text-center mt-4 text-blue-600 hover:text-blue-800">View All Jobs</a>
                        </div>
                    </div>

                    <!-- Suggested Connections -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Suggested Connections</h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-r from-pink-500 to-red-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                            A
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium">Alice Johnson</p>
                                            <p class="text-xs text-gray-500">Software Engineer</p>
                                        </div>
                                    </div>
                                    <button class="text-blue-600 text-sm hover:text-blue-800">Connect</button>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                            B
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium">Bob Smith</p>
                                            <p class="text-xs text-gray-500">Designer</p>
                                        </div>
                                    </div>
                                    <button class="text-blue-600 text-sm hover:text-blue-800">Connect</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
