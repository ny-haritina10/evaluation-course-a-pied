<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\CoureurService;

class CoureurController extends Controller
{
    protected $coureurService;

    public function __construct(CoureurService $coureurService)
    {
        $this->coureurService = $coureurService;
    }

    public function getEquipeCoureurs(Request $request): JsonResponse
    {
        try {
            $coureurs = $this->coureurService->getEquipeCoureurs($request->user());

            return response()->json([
                'status' => 'success',
                'message' => 'Coureurs retrieved successfully',
                'data' => $coureurs
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}