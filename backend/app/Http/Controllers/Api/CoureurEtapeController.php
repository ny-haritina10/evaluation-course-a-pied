<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CoureurEtapeService;
use Illuminate\Support\Facades\Validator;

class CoureurEtapeController extends Controller
{
    protected $coureurEtapeService;

    public function __construct(CoureurEtapeService $coureurEtapeService)
    {
        $this->coureurEtapeService = $coureurEtapeService;
    }

    public function assignCoureurToEtape(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coureur_ids' => 'required|array|min:1', 
            'coureur_ids.*' => 'required|exists:coureurs,id', 
            'etape_id' => 'required|exists:etapes,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $result = $this->coureurEtapeService->assignCoureurToEtape(
                $request->user(), // Authenticated equipe
                $request->coureur_ids, 
                $request->etape_id
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Coureurs assigned to etape successfully',
                'data' => $result
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}