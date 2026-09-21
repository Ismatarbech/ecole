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
        
    Schema::create('eleves', function (Blueprint $table) {
    $table->id();
    $table->string('matricule', 20)->unique();
    $table->string('nom');
    $table->string('prenom');
    $table->date('naissance');
    $table->string('sexe');
    $table->string('lieu');
    $table->string('contact_parent');
    $table->string('tuteur');
    $table->string('contact_tuteur');
    $table->string('photo');
    $table->foreignId('classe_id')->constrained('classes')->cascadeOnDelete();
    $table->foreignId('annee_scolaire_id')->constrained('annee_scolaires')->cascadeOnDelete();
    $table->date('date_inscription');
      
    $table->timestamps();
    $table->softDeletes();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eleves');
    }
};
