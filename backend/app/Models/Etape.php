<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etape extends Model
{
    protected $fillable = [
        'id_course',
        'label',
        'longueur_km',
        'nbr_coureur',
        'date_etape',
        'heure_depart',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class, 'id_course');
    }

    public function coureurs()
    {
        return $this->belongsToMany(Coureur::class, 'etape_coureurs', 'id_etape', 'id_coureur')
                    ->withPivot('id')
                    ->withTimestamps();
    }

    public function rangPoints()
    {
        return $this->hasMany(EtapeRangPoint::class, 'id_etape');
    }
}