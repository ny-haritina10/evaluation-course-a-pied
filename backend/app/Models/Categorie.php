<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = [
        'label',
    ];

    public function coureurs()
    {
        return $this->belongsToMany(Coureur::class, 'coureur_categories', 'id_categorie', 'id_coureur');
    }
}