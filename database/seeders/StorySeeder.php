<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Story;
use Carbon\Carbon;

class StorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users
        $admin = User::where('email', 'admin@example.com')->first();
        $john = User::where('email', 'john@example.com')->first();
        
        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin User',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'headline' => 'Administrateur du réseau',
                'bio' => 'Je suis l\'administrateur de ce réseau professionnel.',
                'location' => 'Paris, France',
                'company' => 'EmploiLink',
            ]);
        }

        if (!$john) {
            $john = User::create([
                'name' => 'John Doe',
                'username' => 'johndoe',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'headline' => 'Développeur Full Stack',
                'bio' => 'Passionné par le développement web et les nouvelles technologies.',
                'location' => 'Lyon, France',
                'company' => 'TechCorp',
            ]);
        }

        // Create sample stories for admin
        $adminStories = [
            [
                'caption' => 'Bonne journée de travail ! ☀️',
                'expires_at' => Carbon::now()->addHours(20),
            ],
            [
                'caption' => 'Nouveau projet en cours... 🚀',
                'expires_at' => Carbon::now()->addHours(15),
            ],
            [
                'caption' => 'Réunion d\'équipe productive !',
                'expires_at' => Carbon::now()->addHours(8),
            ],
        ];

        foreach ($adminStories as $storyData) {
            Story::create([
                'user_id' => $admin->id,
                'media_path' => 'stories/sample-image.jpg', // Placeholder
                'caption' => $storyData['caption'],
                'expires_at' => $storyData['expires_at'],
            ]);
        }

        // Create sample stories for John
        $johnStories = [
            [
                'caption' => 'Coding session en cours 💻',
                'expires_at' => Carbon::now()->addHours(18),
            ],
            [
                'caption' => 'Déjeuner avec l\'équipe 🍕',
                'expires_at' => Carbon::now()->addHours(12),
            ],
            [
                'caption' => 'Nouvelle fonctionnalité déployée !',
                'expires_at' => Carbon::now()->addHours(6),
            ],
            [
                'caption' => 'Weekend bien mérité 🏖️',
                'expires_at' => Carbon::now()->addHours(3),
            ],
        ];

        foreach ($johnStories as $storyData) {
            Story::create([
                'user_id' => $john->id,
                'media_path' => 'stories/sample-image.jpg', // Placeholder
                'caption' => $storyData['caption'],
                'expires_at' => $storyData['expires_at'],
            ]);
        }

        // Create a third user with stories
        $marie = User::firstOrCreate(
            ['email' => 'marie@example.com'],
            [
                'name' => 'Marie Dubois',
                'username' => 'marie_dubois',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'headline' => 'Designer UX/UI',
                'bio' => 'Créatrice d\'expériences utilisateur exceptionnelles.',
                'location' => 'Marseille, France',
                'company' => 'DesignStudio',
            ]
        );

        $marieStories = [
            [
                'caption' => 'Nouveau design en cours 🎨',
                'expires_at' => Carbon::now()->addHours(22),
            ],
            [
                'caption' => 'Inspiration du jour ✨',
                'expires_at' => Carbon::now()->addHours(16),
            ],
            [
                'caption' => 'Prototype terminé !',
                'expires_at' => Carbon::now()->addHours(10),
            ],
        ];

        foreach ($marieStories as $storyData) {
            Story::create([
                'user_id' => $marie->id,
                'media_path' => 'stories/sample-image.jpg', // Placeholder
                'caption' => $storyData['caption'],
                'expires_at' => $storyData['expires_at'],
            ]);
        }
    }
}