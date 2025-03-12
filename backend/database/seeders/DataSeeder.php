<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Insert into genre table
        DB::table('genre')->insert([
            ['id' => 1, 'label' => 'Masculin'],
            ['id' => 2, 'label' => 'Feminin'],
        ]);

        // Insert into categorie table
        DB::table('categorie')->insert([
            ['id' => 1, 'label' => 'Homme'],
            ['id' => 2, 'label' => 'Femme'],
            ['id' => 3, 'label' => 'Junior'],
            ['id' => 4, 'label' => 'Senior'],
            ['id' => 5, 'label' => 'Mixte'],
        ]);

        // Insert into equipes table (with hashed passwords)
        DB::table('equipes')->insert([
            ['id' => 1, 'name_equipe' => 'Equipe A', 'email' => 'equipeA@gmail.com', 'password_equipe' => Hash::make('equipeA')],
            ['id' => 2, 'name_equipe' => 'Equipe B', 'email' => 'equipeB@gmail.com', 'password_equipe' => Hash::make('equipeB')],
            ['id' => 3, 'name_equipe' => 'Equipe C', 'email' => 'equipeC@gmail.com', 'password_equipe' => Hash::make('equipeC')],
        ]);

        // Insert into coureurs table
        DB::table('coureurs')->insert([
            ['id' => 1, 'id_genre' => 1, 'id_equipe' => 1, 'name_coureur' => 'Jack', 'numero_dossard' => 'DOS-001', 'date_naissance' => '2004-01-01'],
            ['id' => 2, 'id_genre' => 2, 'id_equipe' => 1, 'name_coureur' => 'Jackie', 'numero_dossard' => 'DOS-002', 'date_naissance' => '2002-01-01'],
            ['id' => 3, 'id_genre' => 2, 'id_equipe' => 1, 'name_coureur' => 'Franck', 'numero_dossard' => 'DOS-003', 'date_naissance' => '2005-01-01'],
            ['id' => 4, 'id_genre' => 1, 'id_equipe' => 2, 'name_coureur' => 'Paul', 'numero_dossard' => 'DOS-004', 'date_naissance' => '2004-01-01'],
            ['id' => 5, 'id_genre' => 2, 'id_equipe' => 2, 'name_coureur' => 'Steve', 'numero_dossard' => 'DOS-005', 'date_naissance' => '2002-01-01'],
            ['id' => 6, 'id_genre' => 2, 'id_equipe' => 2, 'name_coureur' => 'Garry', 'numero_dossard' => 'DOS-006', 'date_naissance' => '2005-01-01'],
        ]);

        // Insert into coureur_categories table
        DB::table('coureur_categories')->insert([
            ['id' => 1, 'id_coureur' => 1, 'id_categorie' => 1],
            ['id' => 2, 'id_coureur' => 1, 'id_categorie' => 3],
            ['id' => 3, 'id_coureur' => 2, 'id_categorie' => 2],
            ['id' => 4, 'id_coureur' => 3, 'id_categorie' => 3],
            ['id' => 5, 'id_coureur' => 4, 'id_categorie' => 1],
            ['id' => 6, 'id_coureur' => 5, 'id_categorie' => 5],
            ['id' => 7, 'id_coureur' => 6, 'id_categorie' => 1],
            ['id' => 8, 'id_coureur' => 6, 'id_categorie' => 2],
        ]);

        // Insert into courses table
        DB::table('courses')->insert([
            ['id' => 1, 'label' => 'Course A'],
            ['id' => 2, 'label' => 'Course B'],
        ]);

        // Insert into etapes table
        DB::table('etapes')->insert([
            ['id' => 1, 'id_course' => 1, 'label' => 'Etape 0', 'longueur_km' => 5.00, 'nbr_coureur' => 3, 'date_etape' => '2025-06-10', 'heure_depart' => '08:00:00'],
            ['id' => 2, 'id_course' => 1, 'label' => 'Etape 1', 'longueur_km' => 120.50, 'nbr_coureur' => 3, 'date_etape' => '2025-06-11', 'heure_depart' => '08:00:00'],
        ]);

        // Insert into etape_rang_points table
        DB::table('etape_rang_points')->insert([
            // Etape 0
            ['id' => 1, 'id_etape' => 1, 'rang' => 1, 'point_attribue' => 5],
            ['id' => 2, 'id_etape' => 1, 'rang' => 2, 'point_attribue' => 3],
            ['id' => 3, 'id_etape' => 1, 'rang' => 3, 'point_attribue' => 1],

            // Etape 1
            ['id' => 4, 'id_etape' => 2, 'rang' => 1, 'point_attribue' => 6],
            ['id' => 5, 'id_etape' => 2, 'rang' => 2, 'point_attribue' => 4],
            ['id' => 6, 'id_etape' => 2, 'rang' => 3, 'point_attribue' => 2],
        ]);
    }
}