<?php

use App\Models\Cour;
use App\Models\Salle;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->integer('heure_debut');
            $table->integer('heure_fin');
            $table->foreignIdFor(Cour::class)->constrained();
            $table->enum('etat',(['en cours','annulé',]));
            $table->foreignIdFor(Salle::class)->constrained();
            $table->timestamps();
            $table->softDeletes(); // Activation de Soft Delete
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
