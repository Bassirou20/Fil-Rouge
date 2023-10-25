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
        Schema::create('salles', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->foreignId('annee_scolaire_id')->constrained('annee_scolaires');
            $table->integer('numero')->default(0);
            $table->integer('nbre_de_place')->default(0);
            $table->timestamps();
            $table->softDeletes(); // Activation de Soft Delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salles');
    }
};
