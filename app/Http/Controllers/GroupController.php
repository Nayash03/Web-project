<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use App\Models\Cohort;


class GroupController extends Controller
{
    /**
     * Display the page
     *
     * @return Factory|View|Application|object
     */
    public function index() {
       //return view('pages.groups.index');
       // Récupère toutes les cohortes depuis la base de données
       $cohorts = Cohort::all();  
       // Passe les cohortes à la vue 'groups.index'
       return view('pages.groups.index', compact('cohorts'));
    }



}
