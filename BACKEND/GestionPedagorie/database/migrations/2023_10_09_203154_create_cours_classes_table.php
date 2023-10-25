<?php

use App\Models\Classe_annee_scolaire;
use App\Models\Cour;
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
        Schema::create('cours_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classeannee_id')->constrained('classe_annee_scolaire');
            $table->foreignIdFor(Cour::class)->constrained();
            $table->time('nbre_heure');
            $table->time('nbre_heure_effectue');
            // $table->foreignIdFor(Classe::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cours_classes');
    }
};
