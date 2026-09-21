<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'annee_scolaire_id',
        'type',
        'nom',
        'ordre',
        'statut', // active / inactive
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function anneeScolaire()
    {
        return $this->belongsTo(AnneeScolaire::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'periode_id');
    }

    // Vérifie si période utilisable
    public function isOpen(): bool
    {
        return $this->statut === 'active'
            && $this->anneeScolaire?->status === 'active';
    }
}
