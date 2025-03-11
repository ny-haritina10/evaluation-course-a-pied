<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminAuthService
{
    public function login(string $email, string $password): array
    {
        $admin = Admin::where('email', $email)->first();
        if (!$admin || !Hash::check($password, $admin->password_admin)) {
            throw new \Exception('Invalid credentials');
        }

        $token = $admin->createToken('admin-token')->plainTextToken;

        return [
            'admin' => [
                'id' => $admin->id,
                'email' => $admin->email,
            ],
            'token' => $token
        ];
    }
}