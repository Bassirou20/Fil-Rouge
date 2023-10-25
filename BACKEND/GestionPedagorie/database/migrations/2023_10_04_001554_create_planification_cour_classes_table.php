<?php

use App\Models\Classe;
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
        Schema::create('planification_cour_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Classe::class)->constrained();
            $table->foreignIdFor(Cour::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planification_cour_classes');
    }
};
