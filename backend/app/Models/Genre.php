<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = [
        'label',
    ];

    // Relationship with Coureurs
    public function coureurs()
    {
        return $this->hasMany(Coureur::class, 'id_genre');
    }
}