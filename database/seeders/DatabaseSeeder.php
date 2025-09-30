<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            // TypeSalleSeeder::class,
        ]);

        User::create([
            'nom' => 'Admin',
            'prenom' => 'Test',
            'email' => 'admin@example.com',

            'password' => 'admin123',
            'role' => 'Admin',
        ]);

        User::create([
            'nom' => 'Sow',
            'prenom' => 'Ali',
            'email' => 'ali@example.com',
            'password' => 'ali123',
            'role' => 'Etudiant',
        ]);

        User::create([
            'nom' => 'Ba',
            'prenom' => 'Said',
            'email' => 'said@example.com',
            'password' => 'said123',
            'role' => 'Enseignant',
        ]);
    }
}
