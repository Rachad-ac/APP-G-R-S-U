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
            MatiereCoursSeeder::class,
        ]);

        User::create([
            'nom' => 'Admin',
            'prenom' => 'Test',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'id_role' => 1,
        ]);

        User::create([
            'nom' => 'Sow',
            'prenom' => 'Ali',
            'email' => 'ali@example.com',
            'password' => Hash::make('ali123'),
            'id_role' => 2,
        ]);

        User::create([
            'nom' => 'Ba',
            'prenom' => 'Said',
            'email' => 'said@example.com',
            'password' => Hash::make('said123'),
            'id_role' => 3,
        ]);
    }
}
