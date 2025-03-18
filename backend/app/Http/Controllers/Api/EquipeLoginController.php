<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EquipeAuthService;
use Illuminate\Support\Facades\Validator;

class EquipeLoginController extends Controller
{
    protected $equipeAuthService;

    public function __construct(EquipeAuthService $equipeAuthService)
    {
        $this->equipeAuthService = $equipeAuthService;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $result = $this->equipeAuthService->login(
                $request->email,
                $request->password
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'data' => $result
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 401);
        }
    }
}