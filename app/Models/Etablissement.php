<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Etablissement extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nom',
        'logo',
    ];

    public function periodes()
    {
        return $this->hasMany(Periode::class);
    }
}