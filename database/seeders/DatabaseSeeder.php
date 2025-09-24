<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Appelle le seeder des rôles
        $this->call([
            RoleSeeder::class,
        ]);

        // Crée un admin
        User::create([
            'nom' => 'Admin',
            'prenom' => 'Test',
            'email' => 'admin@example.com',
            'password' => 'admin123',
            'id_role' => 1, // Admin
        ]);

        // Crée un Etudiant
        User::create([
            'nom' => 'Sow',
            'prenom' => 'Ali',
            'email' => 'ali@example.com',
            'password' => 'ali123',
            'id_role' => 2, // Etudiant
        ]);

        // Crée un Enseignant
        User::create([
            'nom' => 'Ba',
            'prenom' => 'Said',
            'email' => 'said@example.com',
            'password' => 'said123',
            'id_role' => 3, // Enseignant
        ]);
    }
}
