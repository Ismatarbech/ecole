<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AnneeScolaire extends Model
{
      use SoftDeletes; 
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

       /**
 * Une année scolaire possède plusieurs périodes.
 */
    public function periodes()
    {
        return $this->hasMany(Periode::class, 'annee_scolaire_id')
            ->orderBy('ordre');
    }
}

