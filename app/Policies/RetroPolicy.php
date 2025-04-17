<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Retrospective; 

class RetroPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Retrospective $retro)
    {
        if (!auth()->user()->hasAdminRole()) {
            
        
            // Log pour vérifier les informations
            \Log::info('Vérification d\'autorisation pour l\'utilisateur: ' . $user->id . ' et la rétrospective: ' . $retro->id);

            if ($retro->cohort && $retro->cohort->user_id) {
                \Log::info('Cohort User ID: ' . $retro->cohort->user_id);
                return $user->id === $retro->cohort->user_id;
            }

            \Log::info('Cohort ou User ID du Cohort non valide.');
            return false;
        }
    }



}
