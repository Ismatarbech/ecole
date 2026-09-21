<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Classe extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'niveau_id',
    ];

    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    public function enseignants()
    {
        return $this->belongsToMany(User::class, 'classe_user');
    }

    public function eleves()
    {
        return $this->hasMany(Eleve::class);
    }
}

