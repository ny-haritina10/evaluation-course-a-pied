<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Support\Facades\DB;

class CourseEtapeService
{
    public function getAllCoursesWithDetailedEtapes()
    {
        try {
            $courses = Course::with([
                'etapes' => function ($query) {
                    $query->with([
                        'rangPoints'
                    ]);
                }
            ])->get();

            $result = $courses->map(function ($course) {
                return [
                    'id' => $course->id,
                    'label' => $course->label,
                    'etapes' => $course->etapes->map(function ($etape) {
                        return [
                            'id' => $etape->id,
                            'label' => $etape->label,
                            'longueur_km' => $etape->longueur_km,
                            'nbr_coureur' => $etape->nbr_coureur,
                            'date_etape' => $etape->date_etape,
                            'heure_depart' => $etape->heure_depart,
                            'rang_points' => $etape->rangPoints->map(function ($rangPoint) {
                                return [
                                    'id' => $rangPoint->id,
                                    'rang' => $rangPoint->rang,
                                    'point_attribue' => $rangPoint->point_attribue,
                                ];
                            }),
                            'coureurs' => $etape->coureurs->map(function ($etapeCoureur) {
                                return [
                                    'id' => $etapeCoureur->pivot->id, // etape_coureurs ID
                                    'coureur' => [
                                        'id' => $etapeCoureur->id,
                                        'name_coureur' => $etapeCoureur->name_coureur,
                                        'numero_dossard' => $etapeCoureur->numero_dossard,
                                        'date_naissance' => $etapeCoureur->date_naissance,
                                    ],
                                    'temps' => $etapeCoureur->temps ? [
                                        'id' => $etapeCoureur->temps->id,
                                        'temps_depart' => $etapeCoureur->temps->temps_depart,
                                        'temps_arrivee' => $etapeCoureur->temps->temps_arrivee,
                                    ] : null,
                                ];
                            }),
                        ];
                    }),
                ];
            });

            return $result;

        } catch (\Exception $e) {
            throw new \Exception('Error retrieving courses and etapes: ' . $e->getMessage());
        }
    }
}