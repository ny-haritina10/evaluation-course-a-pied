<?php

namespace App\Http\Controllers\Api;

use App\Services\CourseEtapeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseEtapeController extends Controller
{
    protected $courseEtapeService;

    public function __construct(CourseEtapeService $courseEtapeService)
    {
        $this->courseEtapeService = $courseEtapeService;
    }

    public function index(): JsonResponse
    {
        try {
            $coursesWithEtapes = $this->courseEtapeService->getAllCoursesWithDetailedEtapes();

            return response()->json([
                'status' => 'success',
                'message' => 'Courses and etapes retrieved successfully',
                'data' => $coursesWithEtapes
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}