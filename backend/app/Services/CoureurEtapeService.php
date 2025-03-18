<?php

namespace App\Services;

use App\Models\Equipe;
use App\Models\Coureur;
use App\Models\Etape;

class CoureurEtapeService
{
    public function assignCoureurToEtape(Equipe $equipe, array $coureurIds, int $etapeId): array
    {
        $coureurs = Coureur::whereIn('id', $coureurIds)
            ->where('id_equipe', $equipe->id)
            ->get();

        if ($coureurs->count() !== count($coureurIds)) {
            throw new \Exception('One or more coureurs not found or do not belong to your equipe');
        }

        $etape = Etape::find($etapeId);
        if (!$etape) {
            throw new \Exception('Etape not found');
        }

        $currentCoureurCount = $etape->coureurs()->count();
        $newCoureurCount = $coureurs->count();
        $maxCoureurAllowed = $etape->nbr_coureur;

        $availableSlots = $maxCoureurAllowed - $currentCoureurCount;

        if ($newCoureurCount > $availableSlots) {
            throw new \Exception(
                "Cannot assign $newCoureurCount coureurs. Only $availableSlots slots available out of $maxCoureurAllowed for this etape."
            );
        }

        $existingAssignments = $coureurs->pluck('id')->intersect(
            $etape->coureurs()->pluck('coureurs.id')
        );

        if ($existingAssignments->isNotEmpty()) {
            throw new \Exception('One or more coureurs are already assigned to this etape: ' . $existingAssignments->implode(', '));
        }

        $etape->coureurs()->attach($coureurIds);

        $result = [
            'coureurs' => $coureurs->map(function ($coureur) {
                return [
                    'id' => $coureur->id,
                    'name' => $coureur->name_coureur,
                ];
            })->all(),
            'etape' => [
                'id' => $etape->id,
                'label' => $etape->label,
            ]
        ];

        return $result;
    }
}