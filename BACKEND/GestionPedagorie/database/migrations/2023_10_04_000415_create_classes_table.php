<?php

use App\Models\Niveau;
use App\Models\Filliere;
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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->foreignIdFor(Filliere::class)->constrained();
            $table->foreignIdFor(Niveau::class)->constrained();
            $table->string('effectif');
            $table->timestamps();
            $table->softDeletes(); // Activation de Soft Delete

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
