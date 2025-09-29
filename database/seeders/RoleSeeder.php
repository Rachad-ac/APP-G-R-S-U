<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            ['id_role' => 1, 'nom_role' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 2, 'nom_role' => 'Etudiant', 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 3, 'nom_role' => 'Enseignant', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
