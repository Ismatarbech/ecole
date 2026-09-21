<?php

use App\Models\AnneeScolaire;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Niveau;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

it('allows a teacher to query assigned classes and matieres from the class_user pivot', function () {
    $annee = AnneeScolaire::create([
        'scolaire_annee' => '2026-2027',
        'current_annee' => '2026-2027',
        'status' => 'active',
    ]);

    $niveau = Niveau::create([
        'code' => '6EME',
        'libelle' => 'Sixième',
        'montant' => 25000,
        'annee_scolaire_id' => $annee->id,
    ]);

    $classe = Classe::create([
        'name' => '6A',
        'niveau_id' => $niveau->id,
    ]);

    $matiere = Matiere::create([
        'nom' => 'Mathematiques',
        'description' => 'Mathématiques',
        'coefficient' => 2,
        'niveau_id' => $niveau->id,
    ]);

    
    $role = Spatie\Permission\Models\Role::create(['name' => 'enseignant', 'guard_name' => 'web']);

    $teacher = User::factory()->create();
    $teacher->assignRole($role);

    DB::table('classe_user')->insert([
        'user_id' => $teacher->id,
        'classe_id' => $classe->id,
        'matiere_id' => $matiere->id,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    expect($teacher->classes()->pluck('classes.id')->all())->toContain($classe->id);
    expect($teacher->matieres()->pluck('matieres.id')->all())->toContain($matiere->id);
    expect(Matiere::whereHas('users', fn ($query) => $query->where('users.id', $teacher->id))->pluck('id')->all())->toContain($matiere->id);
});
