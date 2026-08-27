<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
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
        'contact_eleve',
        'contact_parent',
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

    
}
