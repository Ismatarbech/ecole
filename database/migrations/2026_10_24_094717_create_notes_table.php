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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();

            // Élève
            $table->foreignId('eleve_id')
                ->constrained('eleves')
                ->cascadeOnDelete();

            // Matière
            $table->foreignId('matiere_id')
                ->constrained('matieres')
                ->cascadeOnDelete();

            // Enseignant qui a saisi la note
            $table->foreignId('enseignant_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Période
            $table->foreignId('periode_id')
                ->constrained('periodes')
                ->cascadeOnDelete();

            // Notes
            $table->decimal('devoir', 5, 2);
            $table->decimal('composition', 5, 2);

            // Moyenne calculée
            $table->decimal('moyenne', 5, 2)->nullable();

            // Appréciation
            $table->string('appreciation')->nullable();

            // Modification interdite par défaut
            // Seul le Super Admin pourra l'autoriser
            $table->boolean('modification_autorisee')
                ->default(false);

            $table->timestamps();
            $table->softDeletes();

            // Une seule note par élève, matière et période
            $table->unique(
                ['eleve_id', 'matiere_id', 'periode_id'],
                'notes_eleve_matiere_periode_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};