<?php

use App\Models\Classe;
use App\Models\Module;
use App\Models\Professeur;
use App\Models\Semestre;
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
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professeur_id')->constrained('professeurs');
            $table->foreignId('classe_id')->constrained('classes');
            $table->foreignId('semestre_id')->constrained('semestres');
            $table->foreignId('module_id')->constrained('modules');
            $table->integer('quota_horaire'); // Ajout de la colonne de quota horaire global
            $table->timestamps();
            $table->softDeletes(); // Activation de Soft Delete
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cours');
    }
};
