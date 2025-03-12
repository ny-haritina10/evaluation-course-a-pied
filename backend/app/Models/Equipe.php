<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Equipe extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'equipes'; 
    
    protected $fillable = [
        'name_equipe',
        'email',
        'password_equipe',
    ];

    protected $hidden = [
        'password_equipe',
    ];

    public function getAuthPassword()
    {
        return $this->password_equipe;
    }
}