<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paiement extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'eleve_id',
        'annee_scolaire_id',
        'classe_id',
        'montant',
        'mode_paiement',
        'date_paiement',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_paiement' => 'date',
    ];

    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }

    public function anneeScolaire(): BelongsTo
    {
        return $this->belongsTo(AnneeScolaire::class,'annee_scolaire_id');
    }

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

}