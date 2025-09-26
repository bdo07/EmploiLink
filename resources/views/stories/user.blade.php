<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('stories.all') }}" class="text-purple-600 hover:text-purple-800">
                    ← Retour aux Stories
                </a>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Stories de {{ $user->name }}
                </h2>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('profile.show', $user) }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                    Voir le Profil
                </a>
                <a href="{{ route('stories.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                    Créer une Story
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- User Info Header -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                <div class="flex items-center space-x-6">
                    <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                        @if($user->headline)
                            <p class="text-gray-600 dark:text-gray-400">{{ $user->headline }}</p>
                        @endif
                        <div class="flex items-center space-x-4 mt-2">
                            <span class="text-sm text-gray-500">{{ $stories->count() }} stories actives</span>
                            <span class="text-sm text-gray-500">•</span>
                            <span class="text-sm text-gray-500">Membre depuis {{ $user->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if($stories->count() > 0)
                <!-- Stories Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($stories as $story)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 group">
                            <!-- Story Image -->
                            <div class="relative">
                                <div class="w-full h-64 bg-gradient-to-br from-purple-400 via-pink-400 to-red-400 flex items-center justify-center text-white text-6xl">
                                    📸
                                </div>
                                
                                <!-- Story Overlay -->
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <button class="bg-white bg-opacity-90 text-gray-900 px-4 py-2 rounded-lg font-semibold hover:bg-opacity-100 transition">
                                            Voir Story
                                        </button>
                                    </div>
                                </div>

                                <!-- Story Time -->
                                <div class="absolute top-3 left-3 bg-black bg-opacity-50 text-white px-2 py-1 rounded-full text-xs">
                                    {{ $story->created_at->diffForHumans() }}
                                </div>

                                <!-- Story Views Count -->
                                <div class="absolute top-3 right-3 bg-black bg-opacity-50 text-white px-2 py-1 rounded-full text-xs flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $story->views->count() }}
                                </div>
                            </div>

                            <!-- Story Content -->
                            <div class="p-4">
                                @if($story->caption)
                                    <p class="text-gray-900 dark:text-white font-medium mb-2 line-clamp-2">
                                        {{ $story->caption }}
                                    </p>
                                @endif

                                <!-- Story Info -->
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Expire {{ $story->expires_at->diffForHumans() }}
                                    </div>
                                    <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full">
                                        {{ $story->created_at->format('H:i') }}
                                    </span>
                                </div>

                                <!-- Story Actions -->
                                <div class="mt-4 flex space-x-2">
                                    <button class="flex-1 bg-purple-600 text-white px-3 py-2 rounded-lg hover:bg-purple-700 transition text-sm">
                                        Voir
                                    </button>
                                    <button class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition text-sm">
                                        Partager
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Stories Stats -->
                <div class="mt-12 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl p-8 text-white">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold mb-4">Statistiques des Stories</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center">
                                <div class="text-3xl font-bold">{{ $stories->count() }}</div>
                                <div class="text-purple-200">Stories actives</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold">{{ $stories->sum(function($story) { return $story->views->count(); }) }}</div>
                                <div class="text-purple-200">Vues totales</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold">{{ $stories->where('created_at', '>=', now()->subDay())->count() }}</div>
                                <div class="text-purple-200">Stories aujourd'hui</div>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="text-8xl mb-6">📱</div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ $user->name }} n'a pas encore de stories</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-8">Soyez le premier à voir ses stories quand il en partagera !</p>
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('stories.create') }}" class="bg-purple-600 text-white px-8 py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
                            Créer ma Story
                        </a>
                        <a href="{{ route('profile.show', $user) }}" class="bg-gray-600 text-white px-8 py-3 rounded-lg hover:bg-gray-700 transition font-semibold">
                            Voir le Profil
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Floating Actions -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col space-y-3">
        <a href="{{ route('stories.create') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-full shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105 flex items-center space-x-2 font-semibold">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
            </svg>
            <span>Story</span>
        </a>
        
        <a href="{{ route('stories.all') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-full shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105 flex items-center space-x-2 font-semibold">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
            </svg>
            <span>Toutes</span>
        </a>
    </div>
</x-app-layout>
