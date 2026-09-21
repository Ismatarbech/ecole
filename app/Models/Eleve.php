<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Eleve extends Model
{
    use SoftDeletes;
    protected $casts = [
        'naissance' => 'date',
        'date_inscription' => 'date',
    ];

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'naissance',
        'sexe',
        'lieu',
        'contact_parent',
        'tuteur',
        'contact_tuteur',
        'photo',
        'classe_id',
        'date_inscription',
        'annee_scolaire_id',
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function anneeScolaire()
    {
        return $this->belongsTo(AnneeScolaire::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

     public function notes()
    {
        return $this->hasMany(Note::class, 'eleve_id');
    }

    public function etablissement()
    {
        return $this->hasMany(Etablissement::class, 'eleve_id');
    }

    
}
