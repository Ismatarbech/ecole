<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Note;
use App\Models\Niveau;

class Matiere extends Model
{
    use SoftDeletes;
    // Autoriser insertion avec create()
    protected $fillable = [
        'nom',
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

    public function users()
    {
        return $this->belongsToMany(User::class, 'classe_user', 'matiere_id', 'user_id')->distinct();
    }

    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'classe_user', 'matiere_id', 'classe_id')->distinct();
    }

    public function enseignants()
    {
        return $this->users();
    }
}