<?php

namespace App\Services;

use App\Models\Equipe;
use Illuminate\Support\Facades\Hash;

class EquipeAuthService
{
    public function login(string $email, string $password): array
    {
        $equipe = Equipe::where('email', $email)->first();

        if (!$equipe || !Hash::check($password, $equipe->password_equipe)) 
        {throw new \Exception('Invalid credentials'); }

        $token = $equipe->createToken('equipe-token')->plainTextToken;

        return [
            'equipe' => [
                'id' => $equipe->id,
                'name_equipe' => $equipe->name_equipe,
                'email' => $equipe->email,
            ],
            'token' => $token
        ];
    }
}