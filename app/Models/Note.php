<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'eleve_id',
        'matiere_id',
        'enseignant_id',
        'periode_id',
        'devoir',
        'composition',
        'moyenne',
        'appreciation',
        'modification_autorisee',
    ];

    protected $casts = [
        'devoir' => 'decimal:2',
        'composition' => 'decimal:2',
        'moyenne' => 'decimal:2',
        'modification_autorisee' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(User::class, 'enseignant_id');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}