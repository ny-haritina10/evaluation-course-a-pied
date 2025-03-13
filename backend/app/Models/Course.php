<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'label',
    ];

    public function etapes()
    {
        return $this->hasMany(Etape::class, 'id_course');
    }
}