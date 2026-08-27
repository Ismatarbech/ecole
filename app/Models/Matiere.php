<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Note;
use App\Models\Niveau;

class Matiere extends Model
{
    // Autoriser insertion avec create()
    protected $fillable = [
        'nom',
        'description',
        'coefficient',
        'niveau_id'
    ];

    // Relation avec les notes
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

      public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }
}