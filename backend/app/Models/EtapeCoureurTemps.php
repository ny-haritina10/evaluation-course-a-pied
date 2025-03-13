<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtapeCoureurTemps extends Model
{
    protected $table = 'etape_coureur_temps';

    protected $fillable = [
        'id_etape_coureur',
        'temps_depart',
        'temps_arrivee',
    ];

    public function etapeCoureur()
    {
        return $this->belongsTo(EtapeCoureur::class, 'id_etape_coureur');
    }
}