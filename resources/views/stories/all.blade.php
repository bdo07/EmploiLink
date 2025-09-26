<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Toutes les Stories') }}
            </h2>
            <div class="flex items-center space-x-4">
                <a href="{{ route('stories.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                    Créer une Story
                </a>
                <a href="{{ route('feed') }}" class="text-blue-600 hover:text-blue-800">
                    ← Retour au Feed
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if($stories->count() > 0)
                <!-- Stories Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($stories as $userId => $userStories)
                        @php
                            $user = $userStories->first()->user;
                            $latestStory = $userStories->first();
                        @endphp
                        
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <!-- Story Header -->
                            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $userStories->count() }} {{ $userStories->count() > 1 ? 'stories' : 'story' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Story Preview -->
                            <div class="p-6">
                                <div class="relative">
                                    <!-- Story Image Placeholder -->
                                    <div class="w-full h-48 bg-gradient-to-br from-purple-400 via-pink-400 to-red-400 rounded-lg flex items-center justify-center text-white text-4xl mb-4">
                                        📸
                                    </div>
                                    
                                    <!-- Story Caption -->
                                    <div class="mb-4">
                                        <p class="text-gray-900 dark:text-white font-medium">{{ $latestStory->caption }}</p>
                                        <p class="text-sm text-gray-500 mt-1">{{ $latestStory->created_at->diffForHumans() }}</p>
                                    </div>

                                    <!-- Story Stats -->
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <div class="flex items-center space-x-4">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                </svg>
                                                Expire {{ $latestStory->expires_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full">
                                            {{ $userStories->count() }} stories
                                        </span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-4 flex space-x-2">
                                    <a href="{{ route('profile.show', $user) }}" class="flex-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition text-center text-sm">
                                        Voir le Profil
                                    </a>
                                    <button class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition text-sm">
                                        Voir Stories
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Stats Section -->
                <div class="mt-12 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl p-8 text-white">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold mb-4">Statistiques des Stories</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center">
                                <div class="text-3xl font-bold">{{ $stories->count() }}</div>
                                <div class="text-purple-200">Utilisateurs actifs</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold">{{ $stories->flatten()->count() }}</div>
                                <div class="text-purple-200">Stories totales</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold">{{ $stories->flatten()->where('created_at', '>=', now()->subDay())->count() }}</div>
                                <div class="text-purple-200">Stories aujourd'hui</div>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="text-8xl mb-6">📱</div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Aucune story disponible</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-8">Soyez le premier à partager une story avec la communauté !</p>
                    <a href="{{ route('stories.create') }}" class="bg-purple-600 text-white px-8 py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
                        Créer ma première Story
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Floating Create Story Button -->
    <div class="fixed bottom-6 right-6 z-50">
        <a href="{{ route('stories.create') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-full shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105 flex items-center space-x-2 font-semibold">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
            </svg>
            <span>Story</span>
        </a>
    </div>
</x-app-layout>
