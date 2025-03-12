<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Services\DatabaseResetService;
use App\Http\Controllers\Controller;

class DatabaseResetController extends Controller
{
    protected $databaseResetService;

    public function __construct(DatabaseResetService $databaseResetService)
    {
        $this->databaseResetService = $databaseResetService;
    }
    
    public function reset(): JsonResponse
    {
        try {
            $this->databaseResetService->resetDatabase();
            return response()->json(['message' => 'Database reset successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to reset database', 'details' => $e->getMessage()], 500);
        }
    }
}