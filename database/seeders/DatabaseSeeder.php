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
            // TypeSalleSeeder::class,

        ]);

        // Crée un admin
        User::create([
            'nom' => 'Admin',
            'prenom' => 'Test',
            'email' => 'admin@example.com',
            'password' => 'admin123',
            'id_role' => 1, // Admin
        ]);

        // Crée un utilisateur standard
        User::create([
            'nom' => 'User',
            'prenom' => 'Test',
            'email' => 'user@example.com',
            'password' => 'user123',
            'id_role' => 2, // User
        ]);
    }
}
