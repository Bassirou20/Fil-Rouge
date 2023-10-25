<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inscrire_etudiants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classeannee_id')->constrained('classe_annee_scolaire');
            $table->foreignId('etudiant_id')->constrained('etudiants');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscrire_etudiants');
    }
};
