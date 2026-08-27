<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnneeScolaire extends Model
{
    protected $fillable = [
        'scolaire_annee',
        'current_annee',
        'status',
    ];

        public function eleves()
        {
            return $this->hasMany(Eleve::class, 'annee_scolaire_id');
        }

        public function paiements()
        {
            return $this->hasMany(Paiement::class, 'annee_scolaire_id');
        }
}

