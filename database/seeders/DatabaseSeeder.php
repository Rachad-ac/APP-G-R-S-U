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
        ]);

        User::create([
            'nom' => 'Rachad',
            'prenom' => 'Ahmed Combo',
            'email' => 'bent35005@gmail.com',
            'password' => 'rachad123',
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
