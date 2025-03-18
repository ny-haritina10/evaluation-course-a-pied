<?php

namespace App\Services;

use App\Models\Equipe;

class CoureurService
{
    public function getEquipeCoureurs(Equipe $equipe): array
    {
        $coureurs = $equipe->coureurs()->get(['id', 'name_coureur'])->toArray();

        if (empty($coureurs)) 
        { return []; }

        return $coureurs;
    }
}