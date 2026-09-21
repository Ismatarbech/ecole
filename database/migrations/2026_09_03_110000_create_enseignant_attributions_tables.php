<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('classe_user')) {
            return;
        }

        Schema::create('classe_user', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('classe_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('matiere_id')->constrained('matieres')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['user_id', 'classe_id', 'matiere_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classe_user');
    }
};
