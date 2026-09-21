<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Niveau extends Model
{
    use SoftDeletes;
     
    protected $table = 'niveaux';

     // Autoriser insertion avec create()
    protected $fillable = [
        'code',
        'libelle',
        'montant',
        'annee_scolaire_id'
    ];

       // Relation avec les notes
    public function anneeScolaire()
    {
        return $this->belongsTo(AnneeScolaire::class);
    }

    public function classes()
    {
        return $this->hasMany(Classe::class);
    }

        public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    public function eleves()
    {
        return $this->hasMany(Eleve::class);
    }

     public function niveaux()
    {
        return $this->hasMany(Niveau::class);
    }

}
