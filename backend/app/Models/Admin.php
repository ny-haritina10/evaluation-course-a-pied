<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'email',
        'password_admin',
    ];

    protected $hidden = ['password_admin'];

    public function getAuthPassword(): mixed
    {
        return $this->password_admin;
    }
}