<?php

namespace Database\Seeders;

use App\Models\Professeur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProfesseurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Professeur::create([
            'nom_Complet' => 'wane',
            'email' => 'wane@gmail.com',
            'password' =>'douve05',
            'grade' => 'grade 1',
            'spécialité' => 'Microservice',
        ]);
    }
}
