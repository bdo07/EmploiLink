<x-app-layout>
    <x-slot name="header">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Trouvez votre emploi idéal
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">
                Découvrez des opportunités de carrière exceptionnelles
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Hero Section -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 mb-12 text-white">
                <div class="text-center">
                    <h2 class="text-3xl font-bold mb-4">EmploiLink</h2>
                    <p class="text-xl mb-6">Votre réseau professionnel de confiance</p>
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('feed') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                            Voir le Feed
                        </a>
                        @auth
                            <a href="{{ route('jobs.store') }}" class="bg-transparent border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">
                                Poster un Emploi
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                                S'inscrire Gratuitement
                            </a>
                            <a href="{{ route('login') }}" class="bg-transparent border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">
                                Se Connecter
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <input type="text" placeholder="Rechercher un emploi..." class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm">
                    </div>
                    <div>
                        <select class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm">
                            <option value="">Type d'emploi</option>
                            <option value="full_time">Temps plein</option>
                            <option value="part_time">Temps partiel</option>
                            <option value="contract">Contrat</option>
                            <option value="internship">Stage</option>
                        </select>
                    </div>
                    <div>
                        <input type="text" placeholder="Localisation" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm">
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ $jobs->total() }}</div>
                    <div class="text-gray-600 dark:text-gray-400">Emplois disponibles</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center">
                    <div class="text-3xl font-bold text-green-600 mb-2">{{ \App\Models\User::count() }}</div>
                    <div class="text-gray-600 dark:text-gray-400">Utilisateurs actifs</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center">
                    <div class="text-3xl font-bold text-purple-600 mb-2">{{ \App\Models\Post::count() }}</div>
                    <div class="text-gray-600 dark:text-gray-400">Posts partagés</div>
                </div>
            </div>

            <!-- Jobs Grid -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Dernières offres d'emploi
                    </h3>
                    <a href="{{ route('jobs.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        Voir toutes les offres →
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($jobs as $job)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                            <!-- Job Header -->
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                                            {{ substr($job->company, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                <a href="{{ route('jobs.show', $job) }}" class="hover:text-blue-600 transition">
                                                    {{ $job->title }}
                                                </a>
                                            </h4>
                                            <p class="text-gray-600 dark:text-gray-400">{{ $job->company }}</p>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        {{ ucfirst(str_replace('_', ' ', $job->type)) }}
                                    </span>
                                </div>

                                <!-- Job Details -->
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $job->location }}
                                    </div>
                                    @if($job->salary_min || $job->salary_max)
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                                        </svg>
                                        @if($job->salary_min && $job->salary_max)
                                            {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} €
                                        @elseif($job->salary_min)
                                            À partir de {{ number_format($job->salary_min) }} €
                                        @elseif($job->salary_max)
                                            Jusqu'à {{ number_format($job->salary_max) }} €
                                        @endif
                                    </div>
                                    @endif
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Publié {{ $job->created_at->diffForHumans() }}
                                    </div>
                                </div>

                                <!-- Job Description Preview -->
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-3">
                                    {{ Str::limit($job->description, 120) }}
                                </p>

                                <!-- Action Buttons -->
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('jobs.show', $job) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                        Voir l'offre
                                    </a>
                                    @if($job->user)
                                        <span class="text-xs text-gray-500">par {{ $job->user->name }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <div class="text-6xl mb-4">💼</div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Aucune offre d'emploi</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">Revenez bientôt pour découvrir de nouvelles opportunités.</p>
                            @auth
                                <a href="{{ route('jobs.store') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                                    Poster une offre
                                </a>
                            @endauth
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($jobs->hasPages())
                <div class="flex justify-center">
                    {{ $jobs->links() }}
                </div>
            @endif

            <!-- Call to Action -->
            <div class="bg-gradient-to-r from-green-500 to-blue-500 rounded-2xl p-8 mt-12 text-white text-center">
                <h3 class="text-2xl font-bold mb-4">Prêt à commencer votre carrière ?</h3>
                <p class="text-lg mb-6">Rejoignez notre communauté professionnelle et découvrez de nouvelles opportunités</p>
                <div class="flex justify-center space-x-4">
                    @auth
                        <a href="{{ route('feed') }}" class="bg-white text-green-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                            Explorer le Feed
                        </a>
                        <a href="{{ route('jobs.store') }}" class="bg-transparent border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-green-600 transition">
                            Poster un Emploi
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-white text-green-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition shadow-lg">
                            🚀 S'inscrire Gratuitement
                        </a>
                        <a href="{{ route('login') }}" class="bg-transparent border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-green-600 transition">
                            Se connecter
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Sign Up Button (only for guests) -->
    @guest
        <div class="fixed bottom-6 right-6 z-50">
            <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-full shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105 flex items-center space-x-2 font-semibold">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                <span>S'inscrire</span>
            </a>
        </div>
    @endguest
</x-app-layout>
