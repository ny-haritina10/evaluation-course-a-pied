<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coureur extends Model
{
    protected $fillable = [
        'id_genre',
        'id_equipe',
        'name_coureur',
        'numero_dossard',
        'date_naissance',
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'id_genre');
    }

    public function equipe()
    {
        return $this->belongsTo(Equipe::class, 'id_equipe');
    }

    public function categories()
    {
        return $this->belongsToMany(Categorie::class, 'coureur_categories', 'id_coureur', 'id_categorie');
    }

    public function etapes()
    {
        return $this->belongsToMany(Etape::class, 'etape_coureurs', 'id_coureur', 'id_etape')
                    ->withPivot('id')
                    ->withTimestamps();
    }
}