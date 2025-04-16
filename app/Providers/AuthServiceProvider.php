<?php

namespace App\Providers;

use App\Models\Retrospective;
use App\Policies\RetroPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Le modèle et sa politique correspondante.
     *
     * @var array
     */
    protected $policies = [
        Retrospective::class => RetroPolicy::class, // Enregistrement de la politique
    ];

    /**
     * Enregistrer les services d'authentification et les politiques.
     *
     * @return void
     */
    public function boot()
    {
        // Enregistrement automatique des politiques
        $this->registerPolicies();

        // Ici, tu peux également définir des gates personnalisées si nécessaire
    }
}
