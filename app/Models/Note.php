<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Eleve;
use App\Models\User;
use App\Models\Matiere;

class Note extends Model
{
    protected $fillable = [
        'eleve_id',
        'matiere_id',
        'enseignant_id',
        'devoir',
        'composition'
    ];

    // 🔗 relations
    public function eleve()
    {
        return $this->belongsTo(Eleve::class, 'eleve_id');
    }

    public function enseignant()
    {
        return $this->belongsTo(User::class, 'enseignant_id');
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

}