<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtapeRangPoint extends Model
{
    protected $table = 'etape_rang_points';

    protected $fillable = [
        'id_etape',
        'rang',
        'point_attribue',
    ];

    public function etape()
    {
        return $this->belongsTo(Etape::class, 'id_etape');
    }
}