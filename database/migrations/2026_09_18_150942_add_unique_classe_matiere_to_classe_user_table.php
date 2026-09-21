<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('classe_user', function (Blueprint $table) {
            $table->unique(['classe_id', 'matiere_id'], 'classe_matiere_unique');
        });
    }

    public function down(): void
    {
        Schema::table('classe_user', function (Blueprint $table) {
            $table->dropUnique('classe_matiere_unique');
        });
    }
};