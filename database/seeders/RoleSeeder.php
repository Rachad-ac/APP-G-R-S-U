<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'role' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
           ],
           [
               'id' => 2,
               'role' => 'Etudiant',
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'id' => 3,
               'role' => 'Enseignant',
               'created_at' => now(),
               'updated_at' => now(),
           ],
       ]);
    }
}
