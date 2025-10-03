<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matiere;
use App\Models\Cours;

class MatiereCoursSeeder extends Seeder
{
    public function run(): void
    {
        Matiere::insert([
            ['nom' => 'Mathématiques', 'code' => 'MATH101', 'description' => 'Cours de mathématiques de base', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Physique', 'code' => 'PHYS101', 'description' => 'Cours de physique générale', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Informatique', 'code' => 'INFO101', 'description' => 'Cours d’introduction à l’informatique', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Cours::insert([
            ['nom_cours' => 'Algèbre', 'description' => 'Cours d’algèbre', 'id_matiere' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nom_cours' => 'Géométrie', 'description' => 'Cours de géométrie', 'id_matiere' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nom_cours' => 'Mécanique', 'description' => 'Cours de mécanique', 'id_matiere' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nom_cours' => 'Optique', 'description' => 'Cours d’optique', 'id_matiere' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nom_cours' => 'Programmation', 'description' => 'Cours de programmation', 'id_matiere' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['nom_cours' => 'Réseaux', 'description' => 'Cours de réseaux informatiques', 'id_matiere' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
