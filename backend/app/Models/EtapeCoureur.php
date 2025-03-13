<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtapeCoureur extends Model
{
    protected $table = 'etape_coureurs';

    protected $fillable = [
        'id_etape',
        'id_coureur',
    ];

    public function etape()
    {
        return $this->belongsTo(Etape::class, 'id_etape');
    }

    public function coureur()
    {
        return $this->belongsTo(Coureur::class, 'id_coureur');
    }

    public function temps()
    {
        return $this->hasOne(EtapeCoureurTemps::class, 'id_etape_coureur');
    }
}