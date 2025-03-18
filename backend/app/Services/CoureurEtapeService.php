<?php

namespace App\Services;

use App\Models\Equipe;
use App\Models\Coureur;
use App\Models\Etape;

class CoureurEtapeService
{
    public function assignCoureurToEtape(Equipe $equipe, int $coureurId, int $etapeId): array
    {
        $coureur = Coureur::where('id', $coureurId)
            ->where('id_equipe', $equipe->id)
            ->first();

        if (!$coureur) {
            throw new \Exception('Coureur not found or does not belong to your equipe');
        }

        $etape = Etape::find($etapeId);
        if (!$etape) {
            throw new \Exception('Etape not found');
        }

        if ($coureur->etapes()->where('id_etape', $etapeId)->exists()) {
            throw new \Exception('Coureur is already assigned to this etape');
        }

        $coureur->etapes()->attach($etapeId);

        return [
            'coureur' => [
                'id' => $coureur->id,
                'name' => $coureur->name_coureur,
            ],
            'etape' => [
                'id' => $etape->id,
                'label' => $etape->label,
            ]
        ];
    }
}