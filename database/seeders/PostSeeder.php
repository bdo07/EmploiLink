<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the admin user
        $admin = User::where('email', 'admin@example.com')->first();
        
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

        // Create sample posts
        $posts = [
            [
                'body' => 'Bonne journée à tous ! 🌟 Aujourd\'hui, je suis excité de partager avec vous mes réflexions sur l\'avenir du travail et les nouvelles technologies.',
                'visibility' => 'public',
            ],
            [
                'body' => 'Juste terminé une formation passionnante sur Laravel ! Les nouvelles fonctionnalités sont incroyables. Qui d\'autre utilise ce framework ?',
                'visibility' => 'public',
            ],
            [
                'body' => 'Recherche des développeurs talentueux pour rejoindre notre équipe. Si vous êtes passionné par le développement web et que vous cherchez de nouvelles opportunités, n\'hésitez pas à me contacter !',
                'visibility' => 'public',
            ],
            [
                'body' => 'Les réseaux professionnels évoluent rapidement. Il est important de rester connecté et de continuer à apprendre. Quels sont vos conseils pour développer votre réseau professionnel ?',
                'visibility' => 'connections',
            ],
            [
                'body' => 'Merci à tous ceux qui ont participé à notre événement de networking hier soir ! C\'était un succès incroyable. Rendez-vous au prochain !',
                'visibility' => 'public',
            ],
        ];

        foreach ($posts as $postData) {
            Post::create([
                'user_id' => $admin->id,
                'body' => $postData['body'],
                'visibility' => $postData['visibility'],
            ]);
        }

        // Create another user with posts
        $user2 = User::firstOrCreate(
            ['email' => 'john@example.com'],
            [
                'name' => 'John Doe',
                'username' => 'johndoe',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'headline' => 'Développeur Full Stack',
                'bio' => 'Passionné par le développement web et les nouvelles technologies.',
                'location' => 'Lyon, France',
                'company' => 'TechCorp',
            ]
        );

        $user2Posts = [
            [
                'body' => 'Nouveau projet lancé ! Je travaille sur une application révolutionnaire qui va changer la façon dont nous collaborons en ligne.',
                'visibility' => 'public',
            ],
            [
                'body' => 'Conseil du jour : Prenez le temps de documenter votre code. Vos collègues vous remercieront plus tard ! 📝',
                'visibility' => 'public',
            ],
            [
                'body' => 'Recherche des partenaires pour un projet open source. Si vous êtes intéressé par le développement d\'outils pour la communauté, contactez-moi !',
                'visibility' => 'connections',
            ],
        ];

        foreach ($user2Posts as $postData) {
            Post::create([
                'user_id' => $user2->id,
                'body' => $postData['body'],
                'visibility' => $postData['visibility'],
            ]);
        }
    }
}